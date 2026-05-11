<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Allow locations without a postal code (form does not always send zipcode).
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE `industry` MODIFY `zipcode` VARCHAR(10) NULL');
    }

    /**
     * Restore NOT NULL (may fail if any row has NULL zipcode).
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `industry` MODIFY `zipcode` VARCHAR(10) NOT NULL');
    }
};
