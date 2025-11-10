<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ล้างข้อมูลทั้งหมด ยกเว้นตาราง roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('กำลังล้างข้อมูล...');

        $tablesToIgnore = ['migrations', 'roles'];

        Schema::disableForeignKeyConstraints();

        $tables = array_map('current', DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'"));

        foreach ($tables as $table) {
            if (in_array($table, $tablesToIgnore)) {
                continue;
            }
            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();

        $this->info('ล้างข้อมูลเรียบร้อยแล้ว');
    }
}
