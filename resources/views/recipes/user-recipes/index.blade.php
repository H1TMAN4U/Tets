@extends('recipes.user-recipes/master')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pb-8 break-all " style="width: 100%;">
	<div class="w-full overflow-x-auto relative shadow-md sm:rounded-lg break-all my-8">
		<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            
            {{-- Table head --}}
			<thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
				<tr class="bg-gray-300 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
					<th scope="col" class="px-6 py-4 font-medium text-gray-900 hover:text-white  whitespace-nowrap dark:text-gray-400 dark:hover:text-white">
						<a href="{{ route('recipes.create') }}" class="btn btn-success btn-sm float-end" style="transition: 0.5s">Add</a>
					</th>
					<th scope="col" class="px-6 py-4 font-medium text-gray-900 text-center whitespace-nowrap dark:text-gray-400">Recipe name</th>
					<th scope="col" class="w-8 px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-400">Edit/View/Delete</th>
				</tr>
			</thead>

            {{-- counts if recipes are greater than 0 --}}
			@if(count($recipes) > 0)

            {{-- Table content if data exists --}}
			@foreach($recipes as $value)
				<tr class="bg-gray-200 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 dark:hover:bg-gray-7x00">
					<td style="width: 180px;"><img src="{{ asset('images/' . $value->img) }}" width="auto" style="max-height: 150px; height: 100px;"></td>
					<td class="px-2 ">{{ $value->name }}</td>
					<td style="width: 20px">
						<form method="post" class="flex justify-center align-center" action="{{ route('recipes.destroy', $value->id) }}">
							@csrf
							@method('DELETE')
							<a class="px-1 dark:border-gray-700 dark:hover:text-white" href="{{ route('recipes.show', $value->id) }}">View</a>
							<a class="px-1 dark:border-gray-700 dark:hover:text-white"  href="{{ route('recipes.edit', $value->id) }}">Edit</a>
							<input class="px-1 dark:border-gray-700 dark:hover:text-white"  type="submit" class="btn btn-danger btn-sm" value="Delete" style="cursor: pointer"/>
						</form>
					</td>
				</tr>
			@endforeach

            {{-- Table content if data does not exists --}}
			@else
                <tr class="bg-gray-200 dark:border-b border-gray-700 dark:bg-gray-800">
                    <td colspan="8" class="text-center">No Data Found</td>
                </tr>
			@endif

		</table>

        {{-- Pagination --}}
		<div class="">
			{!! $recipes->links() !!}
		</div>

	</div>
</div>
@endsection('content')


