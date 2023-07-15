@php
$smartAds = GlobalFunctions::first_global_function();

@endphp 
<div class="box_shadow" style="margin-top: 0;">
    <div class="container-fluid w90">
        <div class="projecthome">
            <div class="row">
                <div class="col-12">
                    <h2>{!! BaseHelper::clean($title) !!}</h2>
                    @if ($subtitle)
                        <p style="margin: 0 0 10px;">{!! BaseHelper::clean($subtitle) !!}</p>
                    @endif
                </div>
            </div>
            <div class="row rowm10">
                @foreach ($projects as $project)
                    <div class="col-6 col-sm-4  col-md-3 colm10">
                        {!! Theme::partial('real-estate.projects.item', compact('project')) !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="ad-section">
	<div class="container">
		<div class="row">
            <div class="col-md-6 col-sm-12">
                @forelse($smartAds as $ad)
				<div class="inner">
                    @if($ad->image)
                     <a href="https://{{$ad->imageUrl}}" name="is-ads-clicks" value="is-ads-clicks" >
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