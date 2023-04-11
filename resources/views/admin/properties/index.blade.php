@extends('layouts.app')

@section('content')
<section  class="container mt-5">

  @if (session("message"))
    <div class="alert alert-{{ session('alert-type') }}">
      {{ session("message") }}
    </div>
  @endif

  <div class="text-center pb-4 d-flex">
    
    {{-- todo cestrino--}}
    <a href="{{ route("admin.properties.trashed") }}" class="btn btn-bg-purp-light text-white">Cestino</a>
    {{-- todo ricerca--}}
    <form class="d-flex ms-auto d-inline" action="{{ route("admin.properties.search") }}" method="POST">
      @csrf
      <input class="form-control me-2" name="title" placeholder="cerca">
      <button class="btn btn-light" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
  <div class="table-responsive-sm">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Titolo</th>
        <th scope="col" class="custom-responsive-sm">Prezzo a notte</th>
        <th scope="col" class="custom-responsive-sm">N letti</th>
        <th scope="col" class="custom-responsive-sm">N stanze</th>
        <th scope="col" class="custom-responsive-sm">Sponsorizzazione</th>
        <th scope="col" class="custom-responsive-sm">Visibilità</th>
        <th scope="col" class="custom-responsive-sm">Indirizzo</th>
        <th scope="col">Azioni utente</th>
    </thead>
    
    <tbody class="table-group-divider">
      @forelse ($properties as $property)
        <tr class="{{ (!$property->visible) ? 'ms_not-visible' : ''}}">
          <td>{{ $property->title }}</td>
          <td class="custom-responsive-sm">{{ $property->night_price }}</td>
          <td class="custom-responsive-sm">{{ $property->n_beds }}</td>
          <td class="custom-responsive-sm">{{ $property->n_rooms }}</td>
          <td class="custom-responsive-sm">@if($property->sponsorships?->last()?->pivot?->end_date) 
            {{round((strtotime( $property->sponsorships?->last()?->pivot?->end_date) - strtotime(date("Y-m-d H:i:s")))/3600,0).' ore'}} 
            @else <i class="fa-solid fa-xmark text-danger"></i> @endif</td>


          <td class="custom-responsive-sm">@if($property->visible) <i class="fa-solid fa-check text-success"></i> @else <i class="fa-solid fa-xmark text-danger"></i> @endif</td>
          <td class="custom-responsive-sm w-25">{{ $property->address }}</td>
          <td class="">
            <a href="{{ route("admin.properties.show", $property->slug) }}" class="btn btn-primary m-2"><i class="fa-solid fa-eye"></i></a>
            <a href="{{ route("admin.properties.messages", $property->slug) }}" class="btn btn-success m-2"><i class="fa-solid fa-message"></i></a>
            <a href="{{ route("admin.properties.edit", $property->slug) }}" class="btn btn-warning m-2"><i class="fa-solid fa-pen-to-square"></i></a>
            <a href="{{ route("admin.properties.sponsorshipsSelect", $property->slug) }}" class="btn btn-info m-2"><i class="fa-solid fa-rocket"></i></a>
            <form class=" d-inline delete-element" action="{{ route("admin.properties.destroy", $property->slug) }}" method="POST" data-element-name="{{ $property->title }}">
              @csrf
              @method("DELETE")
              <button type="submit" class="btn btn-danger m-2" value="delete"><i class="fa-solid fa-trash-can-arrow-up"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <p class="m-3 fs-4">Il tuo profilo non ha proprietà vai sulla home per aggiungerne una</p>
      @endforelse 
    </tbody>
  </table>
</div>
  {{-- todo paginazione--}}
  {{-- {{ $properties->links() }} --}}
</section>
@endsection


@section("js")
  {{-- popup --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @vite('resources/js/deleteConfirm.js')
@endsection