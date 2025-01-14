<x-sidebar>
  <div class="post_create_container d-flex">
    <div class="post_create_area border w-50 m-5 p-5">
      <div class="">
        <p class="mb-0">カテゴリー</p>
        <select class="w-100" style="border-color: #dee2e6;" form="postCreate" name="post_category_id">
          @foreach($main_categories as $main_category)
          <optgroup label="{{ $main_category->main_category }}">
            <!-- サブカテゴリー表示 -->
            @foreach($main_category->subCategories as $subCategory)
            <!-- {{ $subCategory->id }} で各カテゴリーのid（データベースのユニークID）を値として設定。 -->
            <!-- 例えば、カテゴリーIDが 1 の場合、value="1"となる。 -->
            <option value="{{ $subCategory->id }}">{{ $subCategory->sub_category}}</option>
            @endforeach
          </optgroup>
          @endforeach
        </select>
      </div>

      <div class="mt-3">
        <!-- エラーメッセージ表示 -->
        @if($errors->first('post_title'))
        <span class="error_message">{{ $errors->first('post_title') }}</span>
        @endif
        <p class="mb-0">タイトル</p>
        <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}" style="border: 1px solid #dee2e6; height: 23px;">
      </div>
      <div class="mt-3">
        <!-- エラーメッセージ表示 -->
        @if($errors->first('post_body'))
        <span class="error_message">{{ $errors->first('post_body') }}</span>
        @endif
        <p class="mb-0">投稿内容</p>
        <textarea class="w-100" form="postCreate" name="post_body" style="border: 1px solid #dee2e6;">{{ old('post_body') }}</textarea>
      </div>
      <div class="mt-3 text-right">
        <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
      </div>
      <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
    </div>


    <!-- サイドバー -->
    <div class="w-25 ml-auto mr-auto">
      <div class="category_area mt-5 p-5">
        <!-- メインカテゴリーはすべてのロールで表示 -->
        <div class="">
          <!-- エラーメッセージ表示 -->
          <!-- ->has()内は inputタグで送るname名 -->
          @if($errors->has('main_category_name'))
          <div class="text-danger" style="font-size:12px;">
            {{ $errors->first('main_category_name') }}
          </div>
          @endif
          <p class="m-0">メインカテゴリー</p>
          <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest" style="border: 1px solid #dee2e6; height: 23px;">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest" style="margin-bottom: 30px; margin-top: 15px;">
        </div>

        <!-- サブカテゴリーはroleが1, 2, 3のときのみ表示 -->
        @if (in_array(Auth::user()->role, [1, 2, 3]))
        <div class="mt-3">
          <!-- エラーメッセージ表示① -->
          <!-- ->has()内は inputタグで送るname名 -->
          @if($errors->has('main_category'))
          <div class="text-danger" style="font-size:12px;">
            {{ $errors->first('main_category') }}
          </div>
          @endif
          <!-- エラーメッセージ表示② -->
          @if($errors->has('sub_category_name'))
          <div class="text-danger" style="font-size:12px;">
            {{ $errors->first('sub_category_name') }}
          </div>
          @endif
          <p class="m-0">サブカテゴリー</p>
          <select class="w-100" name="main_category" form="subCategoryRequest" style="border: 1px solid #dee2e6;">
            <option value="none">---</option>
            @foreach($main_categories as $main_category)
            <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
            @endforeach
          </select>
          <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest" style="border: 1px solid #dee2e6; height: 23px;  margin-top: 15px;">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest" style="margin-top: 15px;">
          <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">
            {{ csrf_field() }}
          </form>
        </div>
        @endif
        <!-- メインカテゴリーのフォーム -->
        <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">
          {{ csrf_field() }}
        </form>
      </div>
    </div>
  </div>
</x-sidebar>
