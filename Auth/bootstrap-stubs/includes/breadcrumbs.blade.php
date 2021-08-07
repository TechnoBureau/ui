<div class="container" id="breadcrumb-container">
    <nav class="row pt-4" aria-label="breadcrumb">        
        <ol id="breadcrumb-left" class="breadcrumb float-start" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            @if(count(Request::segments()) > 0)
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <a href="/" itemprop="item" title="Go to Home"><span itemprop="name">Home</span></a>
            </li>
            <?php $segments = ''; ?>
            @foreach(Request::segments() as $segment)
                <?php $segments .= '/'.$segment; ?>
                <li class="breadcrumb-item @if($loop->last) active @endif" @if($loop->last) aria-current="page" @endif itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    @if (!$loop->last)<a href="{{ $segments }}" itemprop="item">@endif
                        <span itemprop="name">{{ucwords(str_replace('-',' ',$segment))}}</span>
                    @if (!$loop->last)</a>@endif
                </li>
            @endforeach
            @endif
        </ol>
    </nav>
</div>
