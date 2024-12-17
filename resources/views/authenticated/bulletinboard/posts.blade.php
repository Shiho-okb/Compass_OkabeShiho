<x-sidebar>
  <div class="board_area w-100 border m-auto d-flex">
    <div class="post_view w-75 mt-5">
      <p class="w-75 m-auto">投稿一覧</p>
      @foreach($posts as $post)
      <div class="post_area border w-75 m-auto p-3">
        <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
        <!-- 投稿タイトル表示 -->
        <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
        <!-- サブカテゴリー表示 -->
        <!-- 投稿内容($post)からリレーションで紐付けたサブカテゴリーを取得 -->
        @foreach($post->subCategories as $subCategory)
        <span class="category_btn">{{ $subCategory->sub_category }}</span>
        @endforeach
        <div class="post_bottom_area d-flex">
          <div class="d-flex post_status">
            <!-- コメント数 -->
            <div class="mr-5">
              <i class="fa fa-comment"></i>
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
    <div class="other_area border w-25">
      <div class="border m-4">
        <!-- 投稿画面遷移ボタン -->
        <div class=""><a href="{{ route('post.input') }}">投稿</a></div>
        <!-- 検索窓 -->
        <div class="">
          <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
          <input type="submit" value="検索" form="postSearchRequest">
        </div>
        <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
        <ul>
          <!-- メインカテゴリー表示 -->
          @foreach($categories as $category)
          <li class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
            <!-- サブカテゴリー表示 -->
            @foreach($category->subCategories as $subCategory)
            <li>
              <!-- {{ $subCategory->id }} で各カテゴリーのid（データベースのユニークID）を値として設定。 -->
              <!-- 例えば、カテゴリーIDが 1 の場合、value="1"となる。 -->
              <form method="GET" action="{{ route('post.show') }}" id="subCategoryForm{{ $subCategory->id }}">
                <input type="hidden" name="category_word" value="{{ $subCategory->id }}">
                <button type="submit" class="category_btn">{{ $subCategory->sub_category }}</button>
              </form>
            </li>
            @endforeach
          @endforeach
        </ul>
      </div>
    </div>
    <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
  </div>
</x-sidebar>
