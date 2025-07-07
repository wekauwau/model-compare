<x-layouts.app>
    <div class="flex flex-col justify-center sm:h-screen p-4">
        <div class="max-w-md w-full mx-auto border border-gray-300 rounded-2xl p-8">
            <div class="text-center mb-12">
                <div class="h-1">Buat Akun</div>
            </div>

            <form action="{{ route('signup.post') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="text-slate-900 text-sm font-medium mb-2 block">Username</label>
                        <input name="username" type="text" value="{{ old('username') }}"
                            class="text-slate-900 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500"
                            placeholder="Masukkan username" />
                    </div>
                    <div>
                        <label class="text-slate-900 text-sm font-medium mb-2 block">Nama Lengkap</label>
                        <input name="nama" type="text" value="{{ old('nama') }}"
                            class="text-slate-900 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500"
                            placeholder="Masukkan nama lengkap" />
                    </div>
                    <div>
                        <label class="text-slate-900 text-sm font-medium mb-2 block">Password</label>
                        <input name="password" type="password"
                            class="text-slate-900 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500"
                            placeholder="Enter password" />
                    </div>
                    <div>
                        <label class="text-slate-900 text-sm font-medium mb-2 block">Confirm Password</label>
                        <input name="cpassword" type="password"
                            class="text-slate-900 bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500"
                            placeholder="Enter confirm password" />
                    </div>
                </div>

                <div class="mt-12">
                    <button type="submit"
                        class="w-full py-3 px-4 text-sm tracking-wider font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none cursor-pointer">
                        Buat akun baru
                    </button>
                </div>
                <p class="text-slate-600 text-sm mt-6 text-center">Sudah punya akun? <a href="{{ route('login') }}"
                        class="text-blue-600 font-medium hover:underline ml-1">Login di sini</a>
                </p>
            </form>
        </div>
    </div>
</x-layouts.app>
