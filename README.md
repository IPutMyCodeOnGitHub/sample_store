**Прогресс выполнения тренингового проекта:**

1.  *Подготовка нового проекта на Symfony*
    
    Приложение модифицировано таким образом, чтобы при обращении к главной странице сайта возвращался JSON, описывающий структуру будущего API.
    Добавлены новые controllers и actions, соответствующие описанию в JSON'е (пока что все URL могут возвращать пустой JSON).
    
    
2.  *Система авторизации*

    Установлены бандлы FOSUserBundle, DoctrineMigrationsBundle, LexikJWTAuthenticationBundle. Создана фикстура для пользователя с помощью DoctrineFixturesBundle.
    Настроен security.yml в соответствии с требуемыми ограничениями доступа. Роуты из секции /my доступны только с предоставлением корректного JWT токена.
    
    
3. *Настройка docker окружения для разработки*
    
    Интрукции к Makefile:

        make init - подъем контейнеров
        
        make createdb - создание БД, накат миграций, загрузка фикстур


        make dropdb - сброс БД

        make getjwt - получение ключа для JWT токена
        
        
4. *Разработка API (base)*

    Созданы основные сущности интерент магазина, унаследовав их от сущностей из SimpleSellerCoreBundle (Order, Product, Category, и т.д.)
    Создайны фикстуры  для заполнения базы тестовыми данными.
    
    http://localhost:8080/catalog/products - список продуктов
    http://localhost:8080/catalog/categories - список категорий 
    http://localhost:8080/my/orders - список заказов (для авторизированного пользователя)  
    

5. *Разработка API (advanced)*
    
    Пример команды для получения JWT-токена:
    curl -X POST -H "Content-Type: application/json" http://localhost:8080/auth/login_check -d '{"username":"user_1@mail.com","password":"123456"}'

    В соответствии с мокапами созданы необходимые методы api:
    1) GET http://localhost:8080/catalog/products - список продуктов
       GET http://localhost:8080/catalog/categories - список категорий
       
    2) GET http://localhost:8080/catalog/categories/{category_id} - список продуктов из категории category_id
    
    3) GET http://localhost:8080/catalog/products/{product_id} - вывод продукта product_id
    
    4) POST http://localhost:8080/my/cart/products/{product_id} - добавление продукта product_id в открытую (status = 0) корзину
       GET http://localhost:8080/my/cart - вывод всех позиций корзины
       
       POST http://localhost:8080/my/orders - создание заказа на основе продуктов из корзины
       с параметрами comment=<COMMENT>, address=<ADDRESS>, phoneNumber=<PHONE_NUMBER>
       
       GET http://localhost:8080/my/orders/{order_id}/items - вывод всех позиций заказа order_id
       GET http://localhost:8080/my/orders - все заказы пользователя
       GET http://localhost:8080/my/profile - профиль пользователя