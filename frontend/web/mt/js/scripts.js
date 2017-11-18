function likecomm(id)
{
    $.get('/main/plus', {id : id}, function(data){
        var data= $.parseJSON(data);
        if(data.likes!="no")
            $('.count_likes'+id).html(' '+data.likes+' ');
        else
            $('#myModal').modal('show');
   });
}
function dislikecomm(id)
{
    $.get('/main/minus', {id : id}, function(data){
        var data= $.parseJSON(data);
        if(data.likes!="no")
            $('.count_likes'+id).html(' '+data.likes+' ');
        else
            $('#myModal').modal('show');
   });
}
/*$("#my-pjax").on("pjax:end", function() {
    $.pjax.reload({container : '#my-pjax-table'});
});*/
/*$("#pjax-reviews").on("pjax:end", function() {
        tops = $("#sortreviews").offset().top;
        $("body,html").animate({scrollTop: tops-15}, 10);
        $.pjax.reload({container : '#my-pjax-table'});
        $.pjax.reload({container : '#my-pjax'});
});*/
$("#my-pjax").on("pjax:start", function() {
    $('#add-review button').html('Отправка...');
    $("#add-review button").attr('disabled',true);

});
$("#my-pjax").on("pjax:end", function() {
    $('#add-review button').html('Добавить');
    $("#add-review button").removeAttr('disabled');
    tops = $("#sortreviews").offset().top;
    $("body,html").animate({scrollTop: tops-15}, 10);
    var urlgr='/'+$('#pjax-table').attr('data-gisp')+'/getraiting';
    $.get(urlgr, {id : $('#tablerait').attr('data-id')}, function(data){
        var data= $.parseJSON(data);
        console.log(data);
        $('#tablerait').text(data.raiting);
        $('#tablerev').text(data.reviews);
   });
});
$('.open_table1').on('click', function(){
   $('.table1').css('display', 'block'); 
   $('.table2').css('display', 'none'); 
   $('.table3').css('display', 'none'); 
   $('.table4').css('display', 'none'); 
   $('#main_butt_text').text($('.table1 caption').text());
});
$('.open_table2').on('click', function(){
   $('.table2').css('display', 'block'); 
   $('.table1').css('display', 'none'); 
   $('.table3').css('display', 'none'); 
   $('.table4').css('display', 'none');
   $('#main_butt_text').text($('.table2 caption').text()); 
});
$('.open_table3').on('click', function(){
   $('.table3').css('display', 'table'); 
   $('.table2').css('display', 'none'); 
   $('.table1').css('display', 'none'); 
   $('.table4').css('display', 'none'); 
   $('#main_butt_text').text($('.table3 caption').text());
});
$('.open_table4').on('click', function(){
   $('.table4').css('display', 'table'); 
   $('.table2').css('display', 'none'); 
   $('.table3').css('display', 'none'); 
   $('.table1').css('display', 'none'); 
   $('#main_butt_text').text($('.table4 caption').text());
});
$(window).resize(function() {
    if($(window).width()==768)
    {
        $('.table1').css('display', 'block'); 
        $('.table2').css('display', 'block'); 
        $('.table3').css('display', 'table');
        $('.table4').css('display', 'table');
    }
    replblock();
});
$(document).ready(function(){
    replblock();
});
function replblock()
{
    if($(window).width()<=768 && $('div').is('.beforenews'))
    {
        var html= $('.rightbdiv').html();
        $('.rightbdiv').remove();
        $('.beforenews').prepend("<div class='rightbdiv'>"+html+"</div>");
    }
}
/*$(function()
{
	$('.wall .row').masonry({itemSelector : '.col-sm-6',});
});*/