<?php

use yii\db\Migration;

/**
 * Class m181004_153058_user
 */
class m181004_153058_user extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $this->db->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

        $this->execute("
        CREATE TABLE public.users
        (
            id serial PRIMARY KEY NOT NULL,
            login varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            username varchar(255) NOT NULL,
            status int DEFAULT 1 NOT NULL
        );
        
        CREATE UNIQUE INDEX users_login_uindex ON public.users (login);
        COMMENT ON COLUMN public.users.login IS 'Логин';
        COMMENT ON COLUMN public.users.password IS 'Пароль';
        COMMENT ON COLUMN public.users.username IS 'Выводимый ник';
        COMMENT ON COLUMN public.users.status IS 'Статус';
        COMMENT ON TABLE public.users IS 'Пользователи';        
      
        ");
    }

    public function down()
    {
        $this->execute('drop table "users"');
    }
}
