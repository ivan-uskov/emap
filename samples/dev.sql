INSERT INTO specie (name) VALUES ('Марий ЭЛ'), ('Татарстан');
INSERT INTO population (name, specie_id) VALUES ('Волжск', 1), ('Йошкар-Ола', 1), ('Казань', 2);
INSERT INTO colony (name, population_id) VALUES ('Набережная', 1), ('Гомзово', 2), ('Заводская', 3);
INSERT INTO family (name, colony_id) VALUES ('Петровы', 1), ('Сидоровы', 2), ('Ивановы', 3);

INSERT INTO melogram (name, file) VALUES ('Колыбельная', ''), ('Крылатые качели', ''), ('Дон и Магдалина', '');

INSERT INTO family_item (family_id, item_id) VALUES (1, 1), (2, 2), (3, 3);
INSERT INTO colony_item (colony_id, item_id) VALUES (1, 1), (2, 2), (3, 3);
INSERT INTO population_item (population_id, item_id) VALUES (1, 1), (2, 2), (3, 3);
INSERT INTO specie_item (specie_id, item_id) VALUES (1, 1), (1, 2), (2, 3);