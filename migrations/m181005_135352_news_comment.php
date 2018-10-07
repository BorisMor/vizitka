<?php

use yii\db\Migration;

/**
 * Class m181005_135352_news_comment
 */
class m181005_135352_news_comment extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->db->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

        $this->execute("
            CREATE TABLE public.news_comment
            (
                id serial PRIMARY KEY NOT NULL,
                news_id int NOT NULL,
                user_id int,
                active int DEFAULT 1 NOT NULL,
                comment text DEFAULT '' NOT NULL,
                date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                name varchar(50) DEFAULT '' NOT NULL,
                CONSTRAINT news_comment_news_id_fk FOREIGN KEY (news_id) REFERENCES public.news (id),
                CONSTRAINT news_comment_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id)
            );
            COMMENT ON COLUMN public.news_comment.news_id IS 'Новость';
            COMMENT ON COLUMN public.news_comment.user_id IS 'Пользователь';
            COMMENT ON COLUMN public.news_comment.active IS 'Активность';
            COMMENT ON COLUMN public.news_comment.comment IS 'Комментрий';
            COMMENT ON COLUMN public.news_comment.date_create IS 'Дата';
            COMMENT ON COLUMN public.news_comment.name IS 'Имя';
            COMMENT ON TABLE public.news_comment IS 'Комментарии для новости';        
        ");
    }

    public function down()
    {
        $this->execute('drop table "news_comment"');
    }
}
