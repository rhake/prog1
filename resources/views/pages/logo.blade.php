@extends('layouts.base')
@section('title', 'Logo em CSS — Autossencial')

@push('head')
<style>
  body { background: #000; }
  .logo-stage {
    min-height: 100vh;
    background: #000;
    color: #f4f4f4;
    display: grid;
    justify-items: center;
    align-content: center;
    gap: 28px;
    padding: 36px 16px 56px;
    font-family: Outfit, "Segoe UI", sans-serif;
  }
  .logo-stage a { color: #f07010; font-weight: 600; }
  .logo-stage h1 {
    font-size: .95rem;
    font-weight: 650;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #9a9a9a;
  }
  .logo-stage p.lead {
    max-width: 36rem;
    text-align: center;
    color: #8d8d8d;
    font-size: .95rem;
  }
  .logo-compare {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    gap: 56px;
    flex-wrap: wrap;
  }
  .logo-compare figure { margin: 0; text-align: center; }
  .logo-compare figcaption {
    margin-top: 16px;
    color: #8a8a8a;
    font-size: .85rem;
    letter-spacing: .04em;
  }
  .logo-compare img {
    width: min(420px, 86vw);
    height: calc(min(420px, 86vw) * 268 / 286);
    object-fit: contain;
  }
  .mark {
    width: min(420px, 86vw);
    height: calc(min(420px, 86vw) * 268 / 286);
    position: relative;
    margin: 0 auto;
    font-size: 0;
    line-height: 0;
  }
  .mark .blade,
  .mark .bracket {
    position: absolute;
    inset: 0;
  }
  .mark .blade { background: #f07010; }
  .mark .bracket { background: #fff; }
  .mark .iris {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: fill;
  }
</style>
@endpush

@section('body')
    <main class="logo-stage">
        <a href="{{ route('home') }}">Voltar ao início</a>
        <h1>Símbolo em CSS</h1>
        <p class="lead">Três modelos: o símbolo inteiro em CSS, só as setas, e as setas em CSS com a íris em PNG.</p>
        <div class="logo-compare">
            <figure>
                <div class="mark" role="img" aria-label="Símbolo da Autossencial desenhado em CSS">
                        <span class="bracket" style="clip-path: polygon(9.09% 28.36%, 9.79% 6.34%, 30.42% 6.72%, 30.77% 10.45%, 30.07% 11.19%, 17.48% 11.19%, 17.13% 11.57%, 23.43% 18.28%, 23.08% 19.40%, 20.63% 22.01%, 13.99% 14.93%, 13.29% 15.67%, 13.64% 28.73%, 9.44% 29.10%)"></span>
                        <span class="bracket" style="clip-path: polygon(68.88% 6.72%, 89.86% 6.34%, 90.21% 28.73%, 86.71% 29.10%, 86.01% 27.99%, 86.36% 16.42%, 85.66% 14.93%, 79.37% 21.64%, 76.22% 18.28%, 82.52% 11.57%, 82.17% 11.19%, 69.58% 11.19%, 68.88% 10.45%)"></span>
                        <span class="bracket" style="clip-path: polygon(9.09% 92.16%, 9.79% 70.15%, 13.29% 70.52%, 13.64% 84.70%, 20.63% 77.24%, 23.78% 80.60%, 16.78% 88.06%, 17.13% 88.43%, 30.42% 88.81%, 30.07% 92.54%, 9.79% 92.91%)"></span>
                        <span class="bracket" style="clip-path: polygon(69.23% 88.81%, 82.52% 88.43%, 82.87% 88.06%, 76.22% 80.97%, 76.22% 80.22%, 78.67% 77.61%, 79.37% 77.61%, 86.01% 84.70%, 86.36% 70.52%, 90.21% 70.52%, 89.86% 92.91%, 69.58% 92.54%)"></span>
                        <span class="blade" style="clip-path: polygon(41.68% 25.04%, 44.06% 23.67%, 50.35% 22.81%, 54.55% 23.28%, 57.64% 24.24%, 58.59% 25.75%, 60.77% 39.34%, 59.79% 39.19%, 42.66% 26.49%)"></span>
                        <span class="blade" style="clip-path: polygon(60.07% 25.61%, 61.19% 25.60%, 63.64% 27.01%, 67.13% 29.90%, 70.48% 33.96%, 72.43% 37.69%, 71.54% 39.93%, 65.48% 49.25%, 64.46% 50.15%, 63.78% 48.88%, 59.93% 26.87%)"></span>
                        <span class="blade" style="clip-path: polygon(27.59% 38.75%, 29.09% 35.45%, 31.48% 32.09%, 34.62% 28.88%, 38.81% 26.01%, 40.21% 26.39%, 47.90% 31.84%, 50.84% 34.58%, 50.00% 35.28%, 29.02% 39.40%, 28.04% 39.39%)"></span>
                        <span class="blade" style="clip-path: polygon(25.31% 46.64%, 26.01% 42.91%, 26.98% 41.48%, 37.06% 38.96%, 40.84% 38.67%, 28.49% 58.21%, 27.33% 59.25%, 26.48% 58.57%, 25.66% 55.60%, 25.19% 52.24%)"></span>
                        <span class="blade" style="clip-path: polygon(60.27% 60.67%, 71.97% 41.42%, 72.76% 40.51%, 73.54% 40.51%, 75.17% 47.39%, 75.09% 53.73%, 73.89% 58.06%, 72.73% 58.72%, 62.24% 61.04%, 60.87% 61.13%)"></span>
                        <span class="blade" style="clip-path: polygon(41.61% 50.00%, 43.01% 48.88%, 47.20% 47.39%, 54.55% 43.66%, 55.59% 43.66%, 55.94% 43.28%, 56.29% 43.66%, 56.29% 44.78%, 50.35% 59.70%, 49.65% 58.96%, 48.60% 52.61%, 47.55% 51.87%, 42.66% 50.75%)"></span>
                        <span class="blade" style="clip-path: polygon(28.21% 61.57%, 35.15% 50.00%, 36.43% 49.18%, 40.27% 74.00%, 39.50% 74.12%, 37.41% 73.01%, 32.53% 68.99%, 29.19% 64.55%)"></span>
                        <span class="blade" style="clip-path: polygon(39.75% 60.37%, 40.80% 61.19%, 48.46% 74.63%, 48.98% 76.06%, 48.53% 76.72%, 44.41% 76.12%, 42.01% 74.58%, 39.65% 61.94%)"></span>
                        <span class="blade" style="clip-path: polygon(51.43% 76.06%, 58.83% 63.34%, 71.68% 60.22%, 72.84% 60.37%, 72.64% 61.94%, 70.32% 66.04%, 64.69% 71.96%, 60.49% 74.52%, 56.64% 75.97%, 52.45% 76.84%)"></span>
                </div>
                <figcaption>CSS</figcaption>
            </figure>
            <figure>
                <img src="{{ asset('images/mark.png') }}" alt="Símbolo original da Autossencial">
                <figcaption>Original</figcaption>
            </figure>
        </div>
        <div class="logo-compare">
            <figure>
                <div class="mark" role="img" aria-label="Apenas as setas do símbolo, em CSS">
                        <span class="bracket" style="clip-path: polygon(9.09% 28.36%, 9.79% 6.34%, 30.42% 6.72%, 30.77% 10.45%, 30.07% 11.19%, 17.48% 11.19%, 17.13% 11.57%, 23.43% 18.28%, 23.08% 19.40%, 20.63% 22.01%, 13.99% 14.93%, 13.29% 15.67%, 13.64% 28.73%, 9.44% 29.10%)"></span>
                        <span class="bracket" style="clip-path: polygon(68.88% 6.72%, 89.86% 6.34%, 90.21% 28.73%, 86.71% 29.10%, 86.01% 27.99%, 86.36% 16.42%, 85.66% 14.93%, 79.37% 21.64%, 76.22% 18.28%, 82.52% 11.57%, 82.17% 11.19%, 69.58% 11.19%, 68.88% 10.45%)"></span>
                        <span class="bracket" style="clip-path: polygon(9.09% 92.16%, 9.79% 70.15%, 13.29% 70.52%, 13.64% 84.70%, 20.63% 77.24%, 23.78% 80.60%, 16.78% 88.06%, 17.13% 88.43%, 30.42% 88.81%, 30.07% 92.54%, 9.79% 92.91%)"></span>
                        <span class="bracket" style="clip-path: polygon(69.23% 88.81%, 82.52% 88.43%, 82.87% 88.06%, 76.22% 80.97%, 76.22% 80.22%, 78.67% 77.61%, 79.37% 77.61%, 86.01% 84.70%, 86.36% 70.52%, 90.21% 70.52%, 89.86% 92.91%, 69.58% 92.54%)"></span>
                </div>
                <figcaption>Só as setas</figcaption>
            </figure>
            <figure>
                <div class="mark" role="img" aria-label="Setas em CSS com a íris laranja em PNG">
                        <span class="bracket" style="clip-path: polygon(9.09% 28.36%, 9.79% 6.34%, 30.42% 6.72%, 30.77% 10.45%, 30.07% 11.19%, 17.48% 11.19%, 17.13% 11.57%, 23.43% 18.28%, 23.08% 19.40%, 20.63% 22.01%, 13.99% 14.93%, 13.29% 15.67%, 13.64% 28.73%, 9.44% 29.10%)"></span>
                        <span class="bracket" style="clip-path: polygon(68.88% 6.72%, 89.86% 6.34%, 90.21% 28.73%, 86.71% 29.10%, 86.01% 27.99%, 86.36% 16.42%, 85.66% 14.93%, 79.37% 21.64%, 76.22% 18.28%, 82.52% 11.57%, 82.17% 11.19%, 69.58% 11.19%, 68.88% 10.45%)"></span>
                        <span class="bracket" style="clip-path: polygon(9.09% 92.16%, 9.79% 70.15%, 13.29% 70.52%, 13.64% 84.70%, 20.63% 77.24%, 23.78% 80.60%, 16.78% 88.06%, 17.13% 88.43%, 30.42% 88.81%, 30.07% 92.54%, 9.79% 92.91%)"></span>
                        <span class="bracket" style="clip-path: polygon(69.23% 88.81%, 82.52% 88.43%, 82.87% 88.06%, 76.22% 80.97%, 76.22% 80.22%, 78.67% 77.61%, 79.37% 77.61%, 86.01% 84.70%, 86.36% 70.52%, 90.21% 70.52%, 89.86% 92.91%, 69.58% 92.54%)"></span>
                        <img class="iris" src="{{ asset('images/mark-iris.png') }}" alt="">
                </div>
                <figcaption>Setas em CSS + íris em PNG</figcaption>
            </figure>
        </div>
    </main>
@endsection
