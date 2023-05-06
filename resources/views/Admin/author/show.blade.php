@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl-4 order-xl-1 mb-5 mb-xl-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="{{ getSingleMedia($author,'profile_image',null) }}" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-7">
                                        <div>
                                            <span class="heading">{{ count($author->getBooks) }}</span>
                                            <span class="description">{{ trans('messages.books') }}</span>
                                        </div>
                                        <div>
                                            <span class="heading">{{ (isset($author->getBookRating) && count($author->getBookRating) > 0 ) ? round(max($author->getBookRating->avg('rating'),0),2) : 0 }}</span>
                                            <span class="description">{{ trans('messages.avg_rating') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="h2">
                                    {{optional($author)->name}}
                                </div>
                                <div class="h4">
                                    {{optional($author)->designation}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-30">
                    <div class="card shadow">
                        <div class="card-header bg-secondary border-0">
                            <h3>{{ trans('messages.author') }} {{ trans('messages.information') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-email">{{ trans('messages.email') }}</label>
                                        <input readonly type="text" id="input-email" class="bg-white form-control form-control-alternative" placeholder="{{ trans('messages.email') }}" value="{{optional($author)->email}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-mobile">{{ trans('messages.mobile') }}</label>
                                        <input readonly type="text" id="input-mobile" class="bg-white form-control form-control-alternative" placeholder="{{ trans('messages.mobile') }}" value="{{optional($author)->mobile}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-education">{{ trans('messages.education') }}</label>
                                        <input readonly type="text" id="input-education" class="bg-white form-control form-control-alternative" placeholder="{{ trans('messages.education') }}" value="{{optional($author)->education}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">{{ trans('messages.address') }}</label>
                                        <input readonly id="input-address" class="bg-white form-control form-control-alternative" placeholder="{{ trans('messages.address') }}" value="{{optional($author)->address}}" type="text">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-2">
            <div class="card shadow">
                <div class="card-header bg-secondary border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ trans('messages.detail') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a id="back" href="{{ isset($extra['redirect_url']) ? $extra['redirect_url'] : route('author.index')}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3"> <i class="fa fa-angle-double-left"></i>   {{ trans('messages.back') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">{{ trans('messages.about_me') }} </h6>
                    <div class="pl-lg-4">
                        <?php echo html_entity_decode(optional($author)->description); ?>
                    </div>
                    @if(count($author->getBooks)>0)
                        <hr class="my-4">
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">{{ trans('messages.books') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group focused">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($author->getBooks->sortByDesc('book_id') as $book)
                                                <div class="col-md-3 pall-10 hover-border text-center">
                                                    <a href="{{route('book.view',['id'=>$book->book_id,'redirect_url'=>url()->current()])}}">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <img src="{{getSingleMedia($book,'front_cover',null)}}" class="hw-90 obj-fit-cov"/>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="single-line-text">
                                                                    {{optional($book)->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
