<x-sidebar>
  <div class="board_area w-100 m-auto d-flex">
    <div class="post_view mt-5" style="width: 70%;">
      @foreach($posts as $post)
      <div class="post_area border m-auto p-3" style="width: 80%;">
        <p>
          <!-- 苗字 -->
          <span style="font-weight: 600; color: #999999;">{{ $post->user->over_name }}</span>
          <!-- 名前 -->
          <span class="ml-3" style="font-weight: 600; color: #999999;">{{ $post->user->under_name }}さん</span>
        </p>
        <!-- 投稿タイトル表示 -->
        <p style="font-weight: 600; color: black;"><a class="title" href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
        <div class="post_bottom_area d-flex">
          <!-- サブカテゴリー表示 -->
          <!-- 投稿内容($post)からリレーションで紐付けたサブカテゴリーを取得 -->
          @foreach($post->subCategories as $subCategory)
          <span class="category_btn btn btn-info" style="background-color: #03AAD2; border-radius: 10px;">{{ $subCategory->sub_category }}</span>
          @endforeach
          <div class="d-flex post_status">
            <!-- コメント数 -->
            <div class="mr-5">
              <i class="fa fa-comment" style="color: #999999;"></i>
              <span class="">{{ $post->postComments->count() }}</span>
            </div>
            <!-- いいね数 -->
            <div>
              @if(Auth::user()->is_Like($post->id))
              <p class="m-0">
                <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
                <span class="like_counts{{ $post->id }}">{{ $post->getLikeCount() }}</span>
              </p>
              @else
              <p class="m-0">
                <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
                <span class="like_counts{{ $post->id }}">{{ $post->getLikeCount() }}</span>
              </p>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>


    <!-- サイドバー -->
    <div class="other_area" style="margin-top: 50px; width: 30%;">
      <div class="">
        <!-- 投稿画面遷移ボタン -->
        <div class="btn btn-info" style="background-color: #03AAD2; width: 80%; margin-bottom: 20px;">
          <a class="post-input" href="{{ route('post.input') }}" style="display: block; text-align: center; width: 100%; height: 100%; color: white; text-decoration: none;">
            投稿
          </a>
        </div>
        <!-- 検索欄 -->
        <div class="" style="margin-bottom: 20px; display: flex;">
          <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest"
            style="width: 60%; background-color: #ecf1f5; border: 1px solid #d3cece; height: 40px; border-radius: 5px 0 0 5px;">
          <input type="submit" value="検索" form="postSearchRequest"
            style="width: 20%; border: none; background-color: #05aad2; color: #fff; height: 40px; border-radius: 0 5px 5px 0;">
        </div>
        <input type="submit" name="like_posts" class="category_btn btn btn-info" value="いいねした投稿" form="postSearchRequest"
          style="background-color: #ea9dc7; border: none; width: 40%; margin-bottom: 20px;">
        <input type="submit" name="my_posts" class="category_btn btn btn-info" value="自分の投稿" form="postSearchRequest"
          style="background-color: #e5bb62; border: none; width: 40%; margin-bottom: 20px;">

        <ul>
          <p><span style="color: #6b6868;">カテゴリー検索</span></p>
          @foreach($categories as $category)
          <li class="main_categories" category_id="{{ $category->id }}"
            style="width: 80%; position: relative; border-bottom: solid 1px #999393; margin-bottom: 15px; margin-top: 5px; cursor: pointer;">
            <span style="color: #6b6868;">{{ $category->main_category }}</span>
            <!-- 矢印アイコン -->
            <span class="accordion_mainCategory-button search-accordion" style="position: absolute; right: 10px;"></span>
          </li>
          <div class="accordion_mainCategory_inner" style="display: none; width: 65%; margin-left: 15px;">
            @foreach($category->subCategories as $subCategory)
            <li>
              <form style="border-bottom: solid 1px #999393; margin-bottom: 15px;" method="GET" action="{{ route('post.show') }}" id="subCategoryForm{{ $subCategory->id }}">
                <input type="hidden" name="category_word" value="{{ $subCategory->id }}">
                <button type="submit" class="category_btn">{{ $subCategory->sub_category }}</button>
              </form>
            </li>
            @endforeach
          </div>
          @endforeach
        </ul>
      </div>
    </div>
    <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
  </div>
</x-sidebar>
