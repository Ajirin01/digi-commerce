<ul>
    @php
        $reviews = $product->reviews;
        $total_reviews = count($reviews);

        $rating = 0;

        foreach ($reviews as $review) {
            $rating += $review->rating;
        }

        if ($total_reviews > 0) {
            $rating /= $total_reviews;
        }

        // echo $rating;
    @endphp

    {{-- {{$product->reviews}} --}}
    @for ($i = 0; $i < 5; $i++)
        @if ($i < $rating)
            <li><i class="ion-android-star"></i></li>
        @else
            <li class="silver-color"><i class="ion-android-star"></i></li>
        @endif
    @endfor
</ul>