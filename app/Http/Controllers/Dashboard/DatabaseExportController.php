<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_settings');
    }

    public function index()
    {
        $connection = config('database.default');
        $isMysql = config("database.connections.$connection.driver") === 'mysql';
        $database = config("database.connections.$connection.database");

        $tables = collect();
        if ($isMysql) {
            $tables = collect(DB::select(
                'SELECT TABLE_NAME as name, TABLE_ROWS as rows_count, (DATA_LENGTH + INDEX_LENGTH) as size_bytes
                 FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? ORDER BY TABLE_NAME',
                [$database]
            ));
        }

        return view('dashboard.export-database', [
            'database' => $database,
            'isMysql' => $isMysql,
            'tables' => $tables,
            'totalSize' => $tables->sum('size_bytes'),
        ]);
    }

    public function download(): StreamedResponse
    {
        $connection = config('database.default');
        abort_unless(config("database.connections.$connection.driver") === 'mysql', 422, 'هذه الميزة تدعم قواعد بيانات MySQL فقط.');

        set_time_limit(0);

        $database = config("database.connections.$connection.database");
        $filename = 'backup_' . $database . '_' . now()->format('Y_m_d_His') . '.sql';

        return response()->streamDownload(function () {
            $this->streamDump();
        }, $filename, ['Content-Type' => 'application/sql; charset=UTF-8']);
    }

    protected function streamDump(): void
    {
        $out = fopen('php://output', 'w');

        fwrite($out, "-- فاهم — نسخة احتياطية من قاعدة البيانات\n");
        fwrite($out, '-- تاريخ الإنشاء: ' . now()->toDateTimeString() . "\n\n");
        fwrite($out, "SET NAMES utf8mb4;\n");
        fwrite($out, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $tables = collect(DB::select('SHOW TABLES'))
            ->map(fn ($row) => array_values((array) $row)[0]);

        foreach ($tables as $table) {
            $this->dumpTable($out, $table);
        }

        fwrite($out, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($out);
    }

    protected function dumpTable($out, string $table): void
    {
        $createRow = DB::select("SHOW CREATE TABLE `$table`");
        $createSql = array_values((array) $createRow[0])[1];

        fwrite($out, "-- --------------------------------------------------------\n");
        fwrite($out, "-- Table: `$table`\n");
        fwrite($out, "-- --------------------------------------------------------\n\n");
        fwrite($out, "DROP TABLE IF EXISTS `$table`;\n");
        fwrite($out, $createSql . ";\n\n");

        $columns = collect(DB::select("SHOW COLUMNS FROM `$table`"))->pluck('Field');
        $columnList = $columns->map(fn ($c) => "`$c`")->implode(', ');
        $pdo = DB::connection()->getPdo();

        $batch = [];
        foreach (DB::table($table)->cursor() as $row) {
            $row = (array) $row;
            $values = $columns->map(function ($col) use ($row, $pdo) {
                $value = $row[$col] ?? null;
                return is_null($value) ? 'NULL' : $pdo->quote((string) $value);
            });
            $batch[] = '(' . $values->implode(', ') . ')';

            if (count($batch) === 500) {
                $this->flushBatch($out, $table, $columnList, $batch);
                $batch = [];
            }
        }
        $this->flushBatch($out, $table, $columnList, $batch);

        fwrite($out, "\n");
    }

    protected function flushBatch($out, string $table, string $columnList, array $batch): void
    {
        if (empty($batch)) {
            return;
        }
        fwrite($out, "INSERT INTO `$table` ($columnList) VALUES\n" . implode(",\n", $batch) . ";\n");
    }
}
