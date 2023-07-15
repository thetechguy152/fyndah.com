@php
$smartAds = GlobalFunctions::first_global_function();
@endphp 
<div class="padtop70">
    <div class="box_shadow">
        <div class="container-fluid w90">
            <div class="homehouse">
                <div class="row">
                    <div class="col-12">
                        <h2>{!! BaseHelper::clean($title) !!}</h2>
                        @if ($subtitle)
                            <p>{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                    </div>
                </div>
                <property-component type="sale" url="{{ route('public.ajax.properties') }}"></property-component>
            </div>
        </div>
    </div>
</div>
<div class="ad-section" style="margin-top:109px">
	<div class="container">
		<div class="row">
            <div class="col-md-6 col-sm-12">
                @forelse($smartAds as $ad)
				<div class="inner">
                    @if($ad->image)
                    <a href="https://{{$ad->imageUrl}}">
                    <img src="{{ asset('storage/'.$ad->image) }}"  >
                    </a>
                    @else 
                    <span>No image found!</span>
                    @endif
				</div>
            </tr>
            @empty
            <tr>
              <td class="p-2 text-gray-800">
                No Ads in the database
              </td>
            </tr>
            @endforelse
			</div>
            <div class="col-md-6 col-sm-12">
                @forelse($smartAds as $ad)
				<div class="inner">
                    @if($ad->image)
                    <a href="https://{{$ad->imageUrl}}">
                    <img src="{{ asset('storage/'.$ad->image) }}"  >
                    </a>
                    @else 
                    <span>No image found!</span>
                    @endif
				</div>
            </tr>
            @empty
            <tr>
              <td class="p-2 text-gray-800">
                No Ads in the database
              </td>
            </tr>
            @endforelse
			</div>
		</div>
	</div>
</div>