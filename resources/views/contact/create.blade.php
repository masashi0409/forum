<x-guest-layout>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 bg-sky-50 h-screen">
    <div class="mx-4 sm:p-8">
      <h1 class="text-xl text-gray-700 font-semibold hover:underline cursor-pointer">お問い合わせ</h1>

      <x-validation-errors class="mb-4" :errors="$errors" />
      <x-message :message="session('message')" />

      <form method="post" action="{{ route('contact.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="">
          <div class="md:flex items-center mt-8">
            <label for="title" class="font-semibold leading-none mt-4">件名</label>
            <input type="text" name="title" id="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md"
              value="{{ old('title') }}" placeholder="件名">
          </div>
        </div>

        <div class="w-full flex flex-col">
          <label for="body" class="font-semibold leading-none mt-4">本文</label>
          <textarea name="body" id="body" cols="30" rows="10"  class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md"></textarea>
        </div>

        <div class="md:flex item-center">
          <div class="w-full flex flex-col">
            <label for="email" class="font-semibold leading-none mt-4">メールアドレス</label>
            <input type="text" name="email" id="email" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md"
              value="{{ old('email') }}" placeholder="email">
          </div>
        </div>

        <x-primary-button class="bg-sky-700 mt-4">送信</x-primary-button>
      </form>

    </div>
  </div>
</x-guest-layout>

<!-- Start of ron4996 Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=691290d4-61af-4048-a727-407167e62202"> </script>
<script type="text/javascript">

  // 認証なくても送信できるので使用していない
  const jwt_token = @json($jwt_token);
  console.log('zendesk setting::')
  console.log(jwt_token);

  window.zESettings = {
    webWidget: {
      errorReporting: true,
      contactForm: {
        attachments: false,
        fields: [
          { id: 'name', prefill: { '*': 'test' } },
          { id: 'email', prefill: { '*': 'test@test.test' } },
          { id: 'description', prefill: { '*': 'My field text.. description' } },
          { id: 2142225, prefill: { '*': 'My custom field text' } }
        ]
      }
    }
  }

  zE('webWidget:on', 'open', function() {
    console.log('The widget has been opened!');
  });
</script>
<!-- End of ron4996 Zendesk Widget script -->