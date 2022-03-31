<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('user.index') }}" class="border border-emerald-400 px-3 py-1">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="mt-6 flex">

                            <div class="flex-1">
                                <label for="name" class="formLabel">Name</label>
                                <input type="text" name="name" id="name" class="formInput" value="{{ $user->name }}">

                                @error('name')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror

                            </div>


                            <div class="flex-1 ml-4">
                                <label for="email" class="formLabel">Email</label>
                                <input type="text" name="email" id="email" class="formInput" value="{{ $user->email }}">
                                @error('email')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex-1 ml-4">
                                <label for="company" class="formLabel">Company</label>
                                <input type="text" name="company" id="company" class="formInput" value="{{ $user->company }}">
                                @error('company')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>




                        </div>


                        <div class="mt-6 flex">

                            <div class="flex-1 ">
                                <label for="phone" class="formLabel">Phone</label>
                                <input type="text" name="phone" id="phone" class="formInput" value="{{ $user->phone }}">
                                @error('phone')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="flex-1 ml-4">
                                <label for="country" class="formLabel">Country</label>


                                <select name="country" id="country" class="formInput">
                                    <option value="none" >Select country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country }}" {{ old('country') == $country ||$user->country == $country? 'selected' :'' }}>{{ $country }}</option>
                                    @endforeach
                                </select>


                                @error('country')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="flex-1 ml-4">
                                <label for="role" class="formLabel">Role</label>

                                <select name="role" id="role" class="formInput">
                                    <option value="none">Select Role</option>


                                    <option value="admin" {{ old('role') == 'admin' ||$user->role == 'admin'? 'selected' :'' }}>Admin</option>
                                    <option value="user" {{ old('role') == 'user' ||$user->role == 'user'? 'selected' :'' }}>User</option>

                                </select>


                                @error('role')
                                <p class="text-red-700 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                            <div class="mt-6  ml-4">
                                <button type="submit"
                                    class="px-4 py-2 text-base uppercase bg-emerald-800 text-white rounded-md">Update</button>
                            </div>

                    </form>


                </div>
            </div>
        </div>
    </div>




</x-app-layout>
