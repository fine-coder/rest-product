# REST for product

### Site:  
http://site3.anipic.org  
http://site3.anipic.org/admin/  
admin  
superpassword  

### Проверка авторизации REST  
http://site3.anipic.org/test  
Обращаться будем к '/rest/product'  
Текстовое поле - логин:пароль  
Можно менять, тогда будет ошибка доступа  
Результат нужно смотреть в консоле

Запросы REST делал программой Insomnia, несколько скринов  
http://site3.anipic.org/rest1.png  
http://site3.anipic.org/rest2.png

Могу REST модулем сделать, версионирование сделать

### Немного текста  
Добавил категории  
3 нужных продукта добавил в категорию 2  
Свойства продукта отдельной таблицей сделал  
Для каждой категории продуктов можно задавать свои свойства  
Названия свойств и их значения также отдельными таблицами - эти данные нужны будут, например, для создания фильтра в каждой категории на фронтенде  
В админке сделал сортировку и фильтрацию по связанным данным, поэтому код админки тоже добавил в репозиторий  
В админке все сделано по-простому

http://site3.anipic.org/rest/product  
http://site3.anipic.org/rest/product-property?expand=product,property,propertyValue&_format=json  
http://site3.anipic.org/rest/property?expand=category  
http://site3.anipic.org/rest/property-value
