$(function () {
  $(document).ready(function () {
    // 矢印アイコンとボタンをクリックしたときの挙動
    $('.accordion-menu').click(function () {
      // メニューを表示/非表示
      $('.accordion_inner').slideToggle();

      // 矢印アイコンを回転
      $('.accordion-button').toggleClass('open');
    });
  });

$(document).ready(function () {
    // 矢印アイコンとボタンをクリックしたときの挙動
    $('.main_categories').click(function () {
      // クリックされたボタンに対応する .accordion_mainCategory_inner のみを開閉
        $(this).next('.accordion_mainCategory_inner').slideToggle();

        // 矢印アイコンの状態を変更
        $(this).find('.accordion_mainCategory-button').toggleClass('open');
    });
});
});
