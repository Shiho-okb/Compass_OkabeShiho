<x-sidebar>
  <div class="vh-100 d-flex">
    <div class="w-50 mt-5">
      <div class="m-3 detail_container" style="border-radius: 10px;">
        <div class="p-3">
          <div class="detail_inner_head">
            <!-- サブカテゴリー表示 -->
            <!-- 投稿内容($post)からリレーションで紐付けたサブカテゴリーを取得 -->
            @foreach($post->subCategories as $subCategory)
            <div>
              <span class="category_btn btn btn-info" style="background-color: #03AAD2; border-radius: 10px; margin-bottom: 15px;">{{ $subCategory->sub_category }}</span>
            </div>
            @endforeach
            <!-- エラーメッセージ表示① -->
            @if($errors->first('post_title'))
            <div>
              <span class="error_message">{{ $errors->first('post_title') }}</span>
            </div>
            @endif
            <!-- エラーメッセージ表示② -->
            @if($errors->first('post_body'))
            <div>
              <span class="error_message">{{ $errors->first('post_body') }}</span>
            </div>
            @endif
            <!-- if文でボタンの出しわけをこのファイルでします -->
            <!-- 自分の投稿かどうかをチェック -->
            <!-- user_idがテーブルのカラム名(Postsテーブルと紐づいているユーザー名が表示される) -->
            @if (Auth::id() === $post->user_id)
            <div>
              <!-- 編集ボタン -->
              <button class="btn btn-primary btn-sm">
                <span class="edit-modal-open" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
              </button>
              <!-- 削除ボタン -->
              <button class="btn btn-danger btn-sm">
                <a href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('この投稿を削除します。よろしいでしょうか？');" style="color:#fff;">削除</a>
              </button>
            </div>
            @endif
          </div>

          <!-- 投稿内容 -->
          <div class="contributor d-flex">
            <p>
              <!-- 苗字 -->
              <span style="font-size: 16px;">{{ $post->user->over_name }}</span>
              <!-- 名前 -->
              <span style="font-size: 16px;">{{ $post->user->under_name }}さん</span>
            </p>
          </div>
          <!-- タイトル -->
          <div class="detsail_post_title" style="font-size: 16px;">{{ $post->post_title }}</div>
          <!-- 投稿内容 -->
          <div class="mt-3 detsail_post" style="font-size: 16px;">{{ $post->post }}</div>
        </div>
        <div class="p-3">
          <div class="comment_container">
            <span class="">コメント</span>
            @foreach($post->postComments as $comment)
            <div class="comment_area border-top">
              <p>
                <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
                <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
              </p>
              <p>{{ $comment->comment }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- コメント機能 -->
    <div class="w-50 p-3">
      <div class="comment_container m-5" style="border-radius: 10px;">
        <div class="comment_area p-3">
          <!-- エラーメッセージ表示 -->
          @if($errors->first('comment'))
          <div>
            <span class="error_message">{{ $errors->first('comment') }}</span>
          </div>
          @endif
          <p class="m-0">コメントする</p>
          <textarea class="w-100" name="comment" form="commentRequest" style="border-color: #ecf1f5;"></textarea>
          <div style="text-align: right;">
            <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
            <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
            <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- モーダルの中身をここに記載 -->
  <div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <form action="{{ route('post.edit') }}" method="post">
        <div class="w-100">
          <div class="modal-inner-title w-50 m-auto">
            <input type="text" name="post_title" placeholder="タイトル" class="w-100">
          </div>
          <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
            <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
          </div>
          <div class="w-50 m-auto edit-modal-btn d-flex">
            <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
            <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
            <input type="submit" class="btn btn-primary d-block" value="編集">
          </div>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
  <!-- モーダルの中身をここに記載 -->

</x-sidebar>
