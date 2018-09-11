<div class="row">
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0">
            <i class="fa fa-gavel text-dark" aria-hidden="true"></i>
            Last Price
        </p>
        @if($last_match)
        <p class="mb-0">
            <a href="{{ route('cards.trades.index', ['card' => $card->slug]) }}">
                {{ number_format($last_match->trading_price_normalized, 8) }}
            </a>
        </p>
        @else
        <p class="mb-0">N/A</p>
        @endif
    </div>
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0">
            <i class="fa fa-money text-dark" aria-hidden="true"></i>
            Currency
        </p>
        @if($last_match)
        <p class="mb-0">
            <a href="{{ route('cards.trades.index', ['card' => $card->slug]) }}">
                {{ explode('/', $last_match->trading_pair_normalized)[1] }}
            </a>
        </p>
        @else
        <p class="mb-0">N/A</p>
        @endif
    </div>
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0">
            <i class="fa fa-users text-dark" aria-hidden="true"></i>
            Collectors
        </p>
        <p class="mb-0"><a href="{{ route('cards.collectors.index', ['card' => $card->slug]) }}">{{ number_format($balances->total()) }}</a></p>
    </div>
    <div class="col-sm-3 d-none d-sm-inline">
        <p class="text-muted mb-0">
            <i class="fa fa-handshake-o text-dark" aria-hidden="true"></i>
            Trades
        </p>
        <p class="mb-0"><a href="{{ route('cards.trades.index', ['card' => $card->slug]) }}">{{ number_format($card->trades_count) }}</a></p>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0" title="{{ $token ? $token->supply_normalized : 'Syncing' }}">
            <i class="fa fa-calculator text-dark" aria-hidden="true"></i>
            Supply
        </p>
        <p class="mb-0">{{ $token ? number_format($token->supply_normalized) : 'Syncing' }}</p>
    </div>
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0" title="{{ $token ? $token->issuance_normalized : 'Syncing' }}">
            <i class="fa fa-{{ $token && $token->locked ? 'lock' : 'unlock-alt' }} text-dark" aria-hidden="true"></i>
            Issued
        </p>
        <p class="mb-0">{{ $token ? number_format($token->issuance_normalized) : 'Syncing' }}</p>
    </div>
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0" title="{{ $token ? $token->burned_normalized : 'Syncing' }}">
            <i class="fa fa-fire text-dark" aria-hidden="true"></i>
            Burned
        </p>
        <p class="mb-0">{{ $token ? number_format($token->burned_normalized) : 'Syncing' }}</p>
    </div>
    <div class="col-sm-3 d-none d-sm-inline">
        <p class="text-muted mb-0">
            <i class="fa fa-{{ $token && $token->divisible ? 'th' : 'square' }} text-dark" aria-hidden="true"></i>
            Divisible
        </p>
        <p class="mb-0">{{ $token && $token->divisible ? 'YES' : 'NO' }}</p>
    </div>
</div>
<div class="d-none d-lg-block">
    <hr />
    <div class="row">
        <div class="col-6">
            <p class="text-muted mb-0">
                <i class="fa fa-chain text-dark" aria-hidden="true"></i>
                Owner
            </p>
            <p class="mb-0"><a href="{{ route('collectors.show', ['collector' => $token ? $token->owner : 'Syncing']) }}">{{ $token ? $token->owner : 'Syncing' }}</a></p>
        </div>
        <div class="col-6">
            <p class="text-muted mb-0">
                <i class="fa fa-chain text-dark" aria-hidden="true"></i>
                Issuer
            </p>
            <p class="mb-0"><a href="{{ route('collectors.show', ['collector' => $token ? $token->issuer : 'Syncing']) }}">{{ $token ? $token->issuer : 'Syncing' }}</a></p>
        </div>
    </div>
</div>
<hr />
<div class="row">  
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0">
            <i class="fa fa-image text-dark" aria-hidden="true"></i>
            Format
        </p>
        <p class="mb-0">
            @foreach($collections as $collection)
                 {{ strtoupper(pathinfo($collection->pivot->image_url, PATHINFO_EXTENSION)) }}{{ $loop->last ? '' : ' / ' }}
            @endforeach
        </p>
    </div>
    <div class="col-4 col-sm-3">
        <p class="text-muted mb-0">
            <i class="fa fa-paint-brush text-dark" aria-hidden="true"></i>
            {{ str_plural('Artist', $artists->count()) }}
        </p>
        <p class="mb-0">
            @foreach($artists as $artist)
                <a href="{{ $artist->url }}">{{ $artist->name }}</a>{{ $loop->last ? '' : ' / ' }}
            @endforeach
            @if($artists->count() === 0)
                <a href="{{ route('artists.card.claim', ['card' => $card->slug]) }}">&plus; CLAIM</a>
            @endif
        </p>
    </div>
</div>