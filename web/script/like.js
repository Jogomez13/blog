$(function(){
  $('.like-toggle1').click(function(){
    $(this).toggleClass('like-active');
    $(this).next().toggleClass('hidden');
  });
});