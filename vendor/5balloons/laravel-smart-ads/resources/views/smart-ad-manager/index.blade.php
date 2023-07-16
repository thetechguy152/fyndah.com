@extends('smart-ads::layouts.app')
@section('content')
<div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Ads
            </h2>

            <!-- Alert Message -->
            @if(session()->has('message'))
            <div class="bg-{{session('color')}}-100 text-{{session('color')}}-800 p-4 text-sm rounded border border-{{session('color')}}-300 my-3">
                  {{session('message')}}
            </div>
            <span class="bg-green-100 bg-red-100"></span> <!--Dummy span-->
            @endif



            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Ad Name</th>
                      <th class="px-4 py-3">Clicks</th>
                      <th class="px-4 py-3">Page Views</th>
                      <th class="px-4 py-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                    @forelse($smartAds as $ad)
                    <tr class="text-gray-700 dark:text-gray-400">

                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <div>
                            <a href="/smart-ad-manager/ads/{{$ad->id}}">
                              <p class="font-semibold">{{$ad->name}}</p>
                            </a>
                          </div>
                        </div>
                      </td>

                      <td class="px-4 py-3 text-sm">
                        {{$ad->clicks}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$ad->views}}
                      </td>
                      <!--
                      <td class="px-4 py-3 text-sm">
                       @if($ad->image)
                        <img src="{{ asset('storage/'.$ad->image) }}" style="height: 50px;width:100px;">
                        @else 
                        <span>No image found!</span>
                        @endif
                      </td>
                    -->
                      <td class="flex px-4 py-3 text-sm">
                         @if($ad->enabled)
                         <form method="POST" action="/smart-ad-manager/ads/disable/{{$ad->id}}" onsubmit="return confirm('Are you sure you want to disable the ad?');">
                            @csrf
                            <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer mr-3 text-red-500">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9v6m-4.5 0V9M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            </button>
                          </form>
                         @else
                         <form method="POST" action="/smart-ad-manager/ads/enable/{{$ad->id}}" onsubmit="return confirm('Are you sure you want to enable the ad?');">
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer mr-3 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                          </svg>
                          </button>
                          </form>
                          @endif
                          <a href="/smart-ad-manager/ads/edit/{{$ad->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer mr-3 text-yellow-600">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                          </a>
                          <a href="/smart-ad-manager/ads/download/{{$ad->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 50 50"><defs><style>.cls-1{fill:#111}.cls-2{fill:#00c569}</style></defs><title>Download</title>
                                <g id="Layer_2" data-name="Layer 2"><g id="Download"><path class="cls-1" d="M47.5 33a2.5 2.5 0 0 0-2.5 2.5v7.75A1.76 1.76 0 0 1 43.25 45H6.75A1.76 1.76 0 0 1 5 43.25V35.5a2.5 2.5 0 0 0-5 0v7.75A6.75 6.75 0 0 0 6.75 50h36.5A6.75 6.75 0 0 0 50 43.25V35.5a2.5 2.5 0 0 0-2.5-2.5z"/>
                                    <path class="cls-1" d="M23.11 38.2l.08.26.13.23a1.86 1.86 0 0 0 .1.2 2.52 2.52 0 0 0 .69.69l.2.1.23.13.26.08.2.11a2.69 2.69 0 0 0 1 0l.21-.06.26-.08.23-.13.2-.1a3.68 3.68 0 0 0 .38-.31l9.19-9.19a2.5 2.5 0 0 0-3.54-3.54L28 31.46V2.5a2.5 2.5 0 0 0-5 0v35a2.72 2.72 0 0 0 .05.49 1.66 1.66 0 0 0 .06.21z"/><rect class="cls-2" x="13.82" y="24.73" width="5" height="11.17" rx="2.5" ry="2.5" transform="rotate(-45 16.32 30.32)"/></g></g></svg>   </a>
                           <!-- New Table
                          <form method="POST" action="/smart-ad-manager/ads/delete/{{$ad->id}}" onsubmit="return confirm('Do you really want to delete?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer text-red-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                              </svg>
                            </button>
                          </form>
                          -->
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td class="p-2 text-gray-800">
                        No Ads in the database
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
              >
                  
               <span class="flex items-center col-span-3">
                  Showing {{$smartAds->firstItem()}}-{{$smartAds->lastItem()}} of {{$smartAds->total()}}
                 </span>
               
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <div class="col-span-4 flex justify-end">
                  {{$smartAds->onEachSide(2)->links()}}
                </div>
              </div>
            </div>

          </div>
@endsection
