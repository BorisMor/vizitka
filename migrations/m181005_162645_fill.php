<?php

use yii\db\Migration;

/**
 * Class m181005_162645_fill
 */
class m181005_162645_fill extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);


        $this->execute("INSERT INTO public.news_category (id, title, parent_id, active) VALUES (1, 'root', 1, 0);");

        $this->execute("
            INSERT INTO public.users (id, login, password, username, status) VALUES (1, 'admin', 'admin', 'Admin', 1);
            INSERT INTO public.users (id, login, password, username, status) VALUES (2, 'login', 'password', 'Test', 1);        
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DELETE FROM news_category;");
        $this->execute("DELETE FROM users;");
    }

}
