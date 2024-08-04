@extends('layout/main')
@section('content')
 <!--================Blog Area =================-->
 <section class="blog_area single-post-area section-padding">
      <div class="container">
         <div class="row">
            <div class="col-lg-8 posts-list">
               <div class="single-post">
                  <div class="feature-img">
                     <img class="img-fluid" src="{{ asset($data->image_url) }}" alt="">
                  </div>
                  <div class="blog_details">
                     <h2>{{ $data->title }}
                     </h2>
                     <ul class="blog-info-link mt-3 mb-4">
                        <li><a href="#"><i class="fa fa-user"></i> {{ $data->category_name }}</a></li>
                        <li><a href="#"><i class="fa fa-comments"></i> {{ $data->comment_count }} Comments</a></li>
                     </ul>
                     {!! $data->content !!}

                  </div>
               </div>
               <div class="navigation-top">
                  <div class="d-sm-flex justify-content-between text-center">
                     <p class="like-info"><span class="align-middle"><i class="fa fa-heart"></i></span> Lily and 4
                        people like this</p>
                     <div class="col-sm-4 text-center my-2 my-sm-0">
                        <!-- <p class="comment-count"><span class="align-middle"><i class="fa fa-comment"></i></span> 06 Comments</p> -->
                     </div>
                     <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fab fa-behance"></i></a></li>
                     </ul>
                  </div>
                  <div class="navigation-area">
                     <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                           <!-- <div class="thumb">
                              <a href="#">
                                 <img class="img-fluid" src="{{ asset('storage/img/post/preview.png') }}" alt="">
                              </a>
                           </div> -->
                           <!-- <div class="arrow">
                              <a href="#">
                                 <span class="lnr text-white ti-arrow-left"></span>
                              </a>
                           </div> -->
                           <div class="detials">
                              <p>Prev Post</p>
                              @if($previousArticle)
                              <a href="{{ url('article/' . $previousArticle->id) }}">
                                 <h4> {{ $previousArticle->title}}</h4>
                              </a>
                              @endif
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                           <div class="detials">
                              <p>Next Post</p>
                              @if($nextArticle)
                              <a href="{{ url('article/' . $nextArticle->id) }}">
                                 <h4>{{ $nextArticle->title }}</h4>
                              </a>
                              @endif
                           </div>
                           <!-- <div class="arrow">
                              <a href="#">
                                 <span class="lnr text-white ti-arrow-right"></span>
                              </a>
                           </div> -->
                           <!-- <div class="thumb">
                              <a href="#">
                                 <img class="img-fluid" src="{{ asset('storage/img/post/next.png') }}" alt="">
                              </a>
                           </div> -->
                        </div>
                     </div>
                  </div>
               </div>
               <div class="blog-author p-1">
                  <div class="media align-items-center">
                     <img src="{{ asset('storage/img/blog/author.png') }}" alt="">
                     <div class="media-body">
                        <a href="#">
                           <h4>{{ $data->author_name }}</h4>
                        </a>
                        <!-- <p>Second divided from form fish beast made. Every of seas all gathered use saying you're, he
                           our dominion twon Second divided from</p> -->
                     </div>
                  </div>
               </div>

               
               <div class="comments-area">
                  <h4>{{ $sumComment }} Comments</h4>
                  <div class="comment-list">

                  @foreach($getCommentById as $item)
                     <div class="single-comment justify-content-between d-flex pb-5">
                        <div class="user justify-content-between d-flex">
                           <div class="thumb">
                              <img src="{{ asset('storage/img/comment/comment_1.png') }}" alt="">
                           </div>
                           <div class="desc">
                              <p class="comment">
                                 {{$item->comment}}
                              </p>
                              <div class="d-flex justify-content-between">
                                 <div class="d-flex align-items-center">
                                    <h5>
                                       <a href="#">{{$item->name}}</a>
                                    </h5>
                                    <p class="date">{{$item->created_at}}</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  @endforeach

                  {{ $getCommentById->links('pagination::bootstrap-4') }}


                  </div>
             
               </div>
               @if(Auth::check())
               <div class="comment-form">
                  <h4>Leave a Reply</h4>
                  <form class="form-contact comment_form mb-80" id="commentForm" action="{{ route('comment') }}" method="POST" >
                  @csrf
                     <div class="row">
                        <div class="col-12">
                           <div class="form-group">
                              <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="3"
                                 placeholder="Write Comment"></textarea>
                                 <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                 <input type="hidden" name="article_id" value="{{$data->id}}">
                           </div>
                        </div>
                     </div>
                     <div class="form-group mt-3">
                        <button type="submit" class="button button-contactForm btn_1 boxed-btn">Send Message</button>
                     </div>
                  </form>
               </div>
               @endif
            </div>
            <div class="col-lg-4">
               <div class="blog_right_sidebar">
                  <aside class="single_sidebar_widget post_category_widget">
                     <h4 class="widget_title">Category</h4>
                     <ul class="list cat-list">
                        @foreach($categories as $item)
                        <li>
                           <a href="#" class="d-flex">
                              <p>{{$item->name}}</p>
                              <p>&nbsp;({{$item->article_count}})</p>
                           </a>
                        </li>
                        @endforeach
                     </ul>
                  </aside>
                  <aside class="single_sidebar_widget popular_post_widget">
                     <h3 class="widget_title">Recent Post</h3>
                     @foreach($recentArticles as $item)
                     <div class="media post_item">
                        <img width="50px" src="{{ asset($item->image_url) }}" alt="">
                        <div class="media-body">
                           <a href="{{ url('article/' . $item->id) }}">
                              <h3>{{$item->title}}.</h3>
                           </a>
                           <p>{{$item->time_since_posted}}</p>
                        </div>
                     </div>
                     @endforeach
                  </aside>
                  <aside class="single_sidebar_widget newsletter_widget">
                     <h4 class="widget_title">Newsletter</h4>
                     <form action="#">
                        <div class="form-group">
                           <input type="email" class="form-control" onfocus="this.placeholder = ''"
                              onblur="this.placeholder = 'Enter email'" placeholder='Enter email' required>
                        </div>
                        <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                           type="submit">Subscribe</button>
                     </form>
                  </aside>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!--================ Blog Area end =================-->
    @endsection