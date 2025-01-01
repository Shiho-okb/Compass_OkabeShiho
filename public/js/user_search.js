$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });


  $(document).ready(function () {
    // 矢印アイコンとボタンをクリックしたときの挙動
    $('.subject_edit_btn, .accordion-button').click(function () {
      $('.subject_inner').slideToggle(); // メニューを表示/非表示
      $('.accordion-button').toggleClass('open'); // 矢印アイコンを回転
    });
  });
});
