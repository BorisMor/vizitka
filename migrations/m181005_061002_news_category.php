<?php

use yii\db\Migration;

/**
 * Class m181005_061002_news_category
 */
class m181005_061002_news_category extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->db->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

        $this->execute("
            CREATE TABLE public.news_category
            (
              id serial PRIMARY KEY NOT NULL,
              title varchar(255) NOT NULL,
              parent_id int DEFAULT 1 NOT NULL,
              active int DEFAULT 1 NOT NULL,
              CONSTRAINT news_category_news_category_id_fk FOREIGN KEY (parent_id) REFERENCES news_category (id)
            );
            COMMENT ON COLUMN public.news_category.title IS 'Название';
            COMMENT ON COLUMN public.news_category.parent_id IS 'Родительская категория';
            COMMENT ON COLUMN public.news_category.active IS 'Активность категории';
            COMMENT ON TABLE public.news_category IS 'Категория новостей';
        
        ");
    }

    public function down()
    {
        $this->execute('drop table "news_category"');
    }

}
