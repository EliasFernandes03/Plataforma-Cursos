<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Nome do usuário
            $table->string('email')->unique();  // Email único para login
            $table->timestamp('email_verified_at')->nullable();  // Verificação de email
            $table->string('password')->nullable();  // Senha para usuários que não usam login social

            // Campos para login social
            $table->string('provider')->nullable();  // Nome do provedor (ex: google, facebook)
            $table->string('provider_id')->nullable();  // ID do usuário no provedor
            $table->string('avatar')->nullable();  // URL do avatar do usuário

            // Papel ou tipo de usuário (ex: admin, professor, aluno)
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');

            // Configurações adicionais
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
