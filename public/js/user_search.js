$(function () {
  $(document).ready(function () {
    // 矢印アイコンとボタンをクリックしたときの挙動
    $('.accordion-button').click(function () {
      // メニューを表示/非表示
      $('.accordion_inner').slideToggle();
      // 矢印アイコンを回転
      $('.accordion-button').toggleClass('open');
    });
  });


  $(document).ready(function () {
    // 矢印アイコンをクリックしたときの挙動
    $('.accordion_mainCategory-button').click(function () {
      // クリックされたボタンに対応する .accordion_mainCategory_inner のみを開閉
      $(this).closest('li.main_categories').next('.accordion_mainCategory_inner').slideToggle();

      // 矢印アイコンの状態を変更
      $(this).toggleClass('open');
    });
  });
});
