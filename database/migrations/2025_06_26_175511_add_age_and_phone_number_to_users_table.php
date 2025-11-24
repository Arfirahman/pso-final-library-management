// database/migrations/xxxx_xx_xx_xxxxxx_add_age_and_phone_number_to_users_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeAndPhoneNumberToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('role'); // Tambahkan kolom age
            $table->string('phone_number', 20)->nullable()->after('age'); // Tambahkan kolom phone_number
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('phone_number');
        });
    }
}