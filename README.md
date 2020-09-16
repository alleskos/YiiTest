## Install

1) docker-compose build
2) docker-compose up
3) docker exec -it  yi_test-php-fpm /bin/bash
 - php yii migrate
 - php yii seed/videos (create 1000 rows by Faker)
 - php yii seed/videos-dublicates-fill (create 1000000 rows by duplicate previous with some random)
4) open http://localhost:8000 in browser

## Explain

1) EXPLAIN SELECT * FROM "videos" WHERE ("added" < '2020-09-05 04:15:35') OR (("added"='2020-09-05 04:15:35') AND ("id" <= 888716)) ORDER BY "added" DESC, "id" DESC LIMIT 50 OFFSET 100;

QUERY PLAN
     
--------------------------------------------------------------------------------
 Limit  (cost=10.56..15.63 rows=50 width=87)
   ->  Index Scan Backward using "idx-videos-added-id" on videos  (cost=0.42..100878.83 rows=995104 width=87)
         Filter: ((added < '2020-09-05 04:15:35'::timestamp without time zone) OR ((added = '2020-09-05 04:15:35'::timestamp without time zone) AND (id <= 888716)))
(3 rows)


2) EXPLAIN SELECT * FROM "videos" WHERE ("views" > 199706) OR (("views"=199706) AND ("id" >= 612143)) ORDER BY "views", "id" LIMIT 20 OFFSET 21;

QUERY PLAN
                    
--------------------------------------------------------------------------------
 Limit  (cost=2.93..5.32 rows=20 width=87)
   ->  Index Scan using "idx-videos-views-id" on videos  (cost=0.42..95889.84 rows=803716 width=87)
         Filter: ((views > 199706) OR ((views = 199706) AND (id >= 612143)))
(3 rows)
