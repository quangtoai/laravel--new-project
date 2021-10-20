 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('emp_code');
            $table->increments('id');
            $table->index(['id']);
            $table->dropPrimary('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('proxy_email')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('temp_pass')->nullable();
            $table->tinyInteger('is_new_pw')->default('1');
            $table->date('retirement_at')->nullable();
            $table->string('role',45)->nullable();
            $table->foreign('role')->references('code')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
//            $table->primary('emp_code');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
