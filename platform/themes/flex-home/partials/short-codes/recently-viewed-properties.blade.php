@php
$smartAds = GlobalFunctions::first_global_function();
@endphp 
<div class="ad-section">
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
<div class="container-fluid w90" style="margin-top:85px">
    <div class="homehouse padtop30">
        <div class="row">
            <div class="col-12">
                <h2>{!! BaseHelper::clean($title) !!}</h2>
                @if ($description)
                    <p>{!! BaseHelper::clean($description) !!}</p>
                @endif
                @if ($subtitle)
                    <p>{!! BaseHelper::clean($subtitle) !!}</p>
                @endif
            </div>
        </div>
        <property-component type="recently-viewed-properties" url="{{ route('public.ajax.properties') }}"></property-component>
    </div>
</div>
