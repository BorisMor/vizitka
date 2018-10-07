<?php

use yii\db\Migration;

/**
 * Class m181005_072906_news
 */
class m181005_072906_news extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

        $this->db->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

        $this->execute("

            CREATE TABLE public.news
            (
                id serial PRIMARY KEY NOT NULL,
                alias VARCHAR(255) NOT NULL,
                title varchar(255) NOT NULL,
                active int DEFAULT 0 NOT NULL,
                category_id int NOT NULL,
                text_short text NOT NULL,
                text_main text NOT NULL,
                user_create_id int NOT NULL,
                date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT news_news_category_id_fk FOREIGN KEY (category_id) REFERENCES public.news_category (id),
                CONSTRAINT news_user_id_fk FOREIGN KEY (user_create_id) REFERENCES public.users (id)
            );
            CREATE UNIQUE INDEX news_alias_uindex ON public.news (alias);
            COMMENT ON COLUMN public.news.alias IS 'алиас';
            COMMENT ON COLUMN public.news.title IS 'Заголовок';
            COMMENT ON COLUMN public.news.active IS 'Активность';
            COMMENT ON COLUMN public.news.category_id IS 'Категория';
            COMMENT ON COLUMN public.news.text_short IS 'Анонс';
            COMMENT ON COLUMN public.news.text_main IS 'Полный текст';
            COMMENT ON COLUMN public.news.user_create_id IS 'Кто создал';
            COMMENT ON COLUMN public.news.date_create IS 'Дата создания';
            COMMENT ON TABLE public.news IS 'Нововсти';        
        
        ");
    }

    public function down()
    {
        $this->execute('drop table "news"');
    }
}
