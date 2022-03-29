//URLから引数に入っている値を渡す処理
function get_param(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return false;
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}


$(document).on('click','.like_btn',function(e){
  e.stopPropagation();
  var $this = $(this),

  user_id = $('input[name=user_id]').val(),//インプット欄の日付を取得
  like_id = $('input[name=like_id]').val(),//インプット欄の日付を取得
  answer_id = $('input[name=answer_id]').val();//インプット欄の日付を取得
  $.ajax({
      type: 'POST',
      url: '../question_disp.php',
      dataType: 'json',
      data: { user_id: user_id,
              answer_id: answer_id}
  }).done(function(data){
      location.reload();
  }).fail(function() {
    location.reload();
  });
});