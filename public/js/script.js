$(document).ready(function() {

    /**
     * модальное окно: добавление товара в корзину
     */
    $('.basket_create').click(function() {

        var current_obj = $(this);

        var category_id = current_obj.parent().parent().find('input[name="category_id"]').val();
        var category_manufacturing = current_obj.parent().parent().find('input[name="category_manufacturing"]').val();
        var category_stock = current_obj.parent().parent().find('input[name="category_stock"]').val();
        var good_id = current_obj.parent().parent().find('.good_id').html();
        var good_name = current_obj.parent().parent().find('.good_name').html();
        var good_category_name = current_obj.parent().parent().find('.good_category_name').html();

        $('#basket #basket_title').html(good_category_name+' / <b>'+good_name+'</b>');

        $('#basket input[name="good_id"]').val(good_id);
        $('#basket input[name="category_id"]').val(category_id);
        $('#basket input[name="category_manufacturing"]').val(category_manufacturing);
        $('#basket input[name="category_stock"]').val(category_stock);

    });

    /**
     * модальное окно: добавление товара в бд
     */
    $('.basket_add').click(function() {

        var current_obj = $(this);
        var count = current_obj.parent().find('input[name="count"]').val();



        var good_id = current_obj.parent().find('input[name="good_id"]').val();
        var category_id = current_obj.parent().find('input[name="category_id"]').val();
        var category_manufacturing = current_obj.parent().find('input[name="category_manufacturing"]').val();
        var category_stock = current_obj.parent().find('input[name="category_stock"]').val();
        var token = $('input[name="_token"]').val();

        count_items = parseInt(count);
        if(count_items > 0)
        {

            current_obj.parent().find('input[name="count"]').css('border', '1px solid #ced4da;');

            $.post('/goods/basket/create', {'_token': token, 'category_id': category_id, 'category_manufacturing' : category_manufacturing, 'category_stock' : category_stock, 'good_id': good_id, 'count': count}, function(data) {

                $('#basket').modal('hide');

                // подгружаем дерево товаров в корзине
                $.post('/goods/ajax/get_tree', {'_token' : token}, function(data) {

                    $('div#basket_items').html(data);

                });

            });

        } else {
            current_obj.parent().find('input[name="count"]').css('border', '1px solid #ff0000');

        }

    });


    /**
     * поиск товара
     */
    $('input[name="search_goods_field"]').keyup(function() {

        var current_obj = $(this);
        var name = current_obj.val();
        var token = $('input[name="_token"]').val();

        $.post('/goods/search', {'name' : name, 'search': true, '_token' : token}, function(data) {

            $('.table-goods').html(data);

        });

    });


    /**
     * изменение количества товара в корзине
     */
    $('input[name="count_items_in_basket"]').change(function() {

        var current_obj = $(this);
        var count = current_obj.val();
        var basket_id = current_obj.parent().find('input[name="basket_id"]').val();
        var token = $('input[name="_token"]').val();

        // обновляем кол-во товаров в корзине
        $.post('/basket/change_count', {'_token' : token, 'count' : count, 'basket_id' : basket_id}, function(data) {

        });

    });


    /**
     * увеличение кол-ва товара на единицу
     */
    $('.act-plus').click(function() {

        var current_obj = $(this);
        var field = current_obj.parent().find('input[name="count"]');
        var count_items = parseInt(current_obj.parent().find('input[name="count"]').val());
        count_items = count_items + 1;
        field.val(count_items);

    });


    /**
     * уменьшение кол-ва товара на единицу
     */
    $('.act-minus').click(function() {

        var current_obj = $(this);
        var field = current_obj.parent().find('input[name="count"]');
        var count_items = parseInt(current_obj.parent().find('input[name="count"]').val());
        count_items = count_items - 1;
        if(count_items >= 0)
        {
            field.val(count_items);
        }

    });


    /**
     * очистка корзины
     */
    $('.clear-basket').click(function() {

        var current_obj = $(this);

        if(confirm('Вы действительно хотите очистить корзину?'))
        {

            var token = $('input[name="_token"]').val();

            $.post('/basket/clear', {'_token': token}, function(data) {

                $('#basket_items').html('');

            });

        } else return false;

    });

});