$(function(){
    
    console.log('Привет, это страый js ))');
    init_get_new();  // добавлены новые функции
    init_post_new(); // добавлены  новые функции
    init_get();
    init_post();
    

});

function init_get() 
{
    $('a.ajaxArticleBodyByGet').one('click', function(){
        
        var contentId = $(this).attr('data-contentId');
        // alert (contentId);
        console.log('ID статьи = ', contentId); 
        showLoaderIdentity();
        $.ajax({
            url:'/ajax/showContentsHandler.php?articleId=' + contentId, 
            dataType: 'text'
        })
        
   
        .done (function(obj){
            hideLoaderIdentity();
            console.log('Ответ получен');
            $('li.' + contentId).append(obj);
        })
        
        .fail(function(xhr, status, error){
            hideLoaderIdentity();
    
            console.log('ajaxError xhr:', xhr); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
     
            console.log('Ошибка соединения при получении данных (GET)');
        });
        
        return false;
        
    });  
}

function init_get_new() 
{
    $('a.ajaxGETnew').one('click', function(){
        
        var contentId = $(this).attr('data-contentId');
        // alert (contentId);
        console.log('ID статьи = ', contentId); 
        showLoaderIdentity();
        $.ajax({
            url:'/ajax/showContentsHandler.php?articleId=' + contentId, 
            dataType: 'text'
        })
        
   
        .done (function(obj){
            hideLoaderIdentity();
            console.log('Ответ получен');
            $('li.' + contentId).append(obj);
        })
        
        .fail(function(xhr, status, error){
            hideLoaderIdentity();
    
            console.log('ajaxError xhr:', xhr); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
     
            console.log('Ошибка соединения при получении данных (GET)');
        });
        
        return false;
        
    });  
}

function init_post() 
{
    $('a.ajaxArticleBodyByPost').one('click', function(){
        var content = $(this).attr('data-contentId');
        showLoaderIdentity();
        $.ajax({
            url:'/ajax/showContentsHandler.php', 
            dataType: 'text',
            data: { articleId: content},
            method: 'POST'
        })
        .done (function(obj){
            hideLoaderIdentity();
            console.log('Ответ получен', obj);
            $('li.' + content).append(obj);
        })
        .fail(function(xhr, status, error){
            hideLoaderIdentity();
    
    
            console.log('Ошибка соединения с сервером (POST)');
            console.log('ajaxError xhr:', xhr); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
        });
        
        return false;
        
    });  
}



function init_post_new() 
{
    $('a.ajaxPOSTnew').one('click', function(){
        var content = $(this).attr('data-contentId');
        showLoaderIdentity();
        $.ajax({
            url:'/ajax/showContentsHandler.php', 
            dataType: 'text',
            data: { articleId: content},
            method: 'POST'
        })
        .done (function(obj){
            hideLoaderIdentity();
            console.log('Ответ получен', obj);
            $('li.' + content).append(obj);
        })
        .fail(function(xhr, status, error){
            hideLoaderIdentity();
    
    
            console.log('Ошибка соединения с сервером (POST)');
            console.log('ajaxError xhr:', xhr); // выводим значения переменных
            console.log('ajaxError status:', status);
            console.log('ajaxError error:', error);
        });
        
        return false;
        
    });  
}