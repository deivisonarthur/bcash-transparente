use warnings;
use strict;
use Test::More;
use HTTP::Request::Common;
use LWP::UserAgent;
use Digest::MD5 qw(md5 md5_hex md5_base64);
use Time::HiRes qw(gettimeofday);
use MIME::Base64;
use warnings;
use strict;
use JSON;

my $json = JSON->new->utf8;
my $consumerKey = '1f5c18f0e65699f2568ca2751654fa7fc5ce94b0';
my $sellerMail  = 'lojamodelo@pagamentodigital.com.br';

my $time = time() * 1000;
my ( $sec, $msec ) = gettimeofday();
my $microtime = "0.${msec}00 $sec";

my $rand = rand();

my $sign = {
  oauth_consumer_key     => $consumerKey,
  oauth_nonce            => md5_hex( $microtime . $rand ),
  oauth_signature_method => 'PLAINTEXT',
  oauth_timestamp        => $time,
  oauth_version          => '1.0',
};

my $to_sign = join '&',
  map {"$_=$sign->{$_}"}
  qw(oauth_consumer_key oauth_nonce oauth_signature_method oauth_timestamp oauth_version);
warn $to_sign;
my $signature = encode_base64( $to_sign, '' );
warn $signature;
$sign->{oauth_signature} = $signature;

my $auth_header = join ',',
  map {"$_=$sign->{$_}"}
  qw(oauth_consumer_key oauth_nonce oauth_signature oauth_signature_method oauth_timestamp oauth_version);

my $oAuth =
  'OAuth realm=https://api.bcash.com.br/service/createTransaction/xml/,'
  . $auth_header;

my $dados_object = {
  acceptedContract => "S",
  buyer            => {
    address => {
      address      => "a",
      city         => "Cachoeirinha",
      complement   => "sdasd",
      neighborhood => "aasda",
      number       => "1",
      state        => "RS",
      zipCode      => "94970-825",
    },
    birthDate => "",
    cellPhone => "",
    cpf       => "57279548512",
    gender    => "M",
    mail      => "email\@consumidor.com",
    name      => "Loja 2",
    phone     => "5133258626",
    rg        => "",
  },
  creditCard => {
    holder        => "Teste Bcash",
    maturityMonth => "03",
    maturityYear  => "2017",
    number        => "4111111111111111",
    securityCode  => "123",
  },
  installments  => "1",
  orderId       => "1",
  paymentMethod => { code => "1" },
  platformId    => "423",
  products      => [{
    amount           => "1",
    code             => "1",
    description      => "Teste",
    extraDescription => "",
    value            => "0.01",
  }],
  sellerMail     => "lojamodelo\@pagamentodigital.com.br",
  viewedContract => "S",
};
my $data = $json->encode($dados_object);
use URI;
my $uri = URI->new('/');
$uri->query_form({ data => $data, version => "1.0", encode => "ISO-8859-1"});
my $query = $uri->query;
my $req = POST(
  ( $ENV{DEBUG}
    ? 'http://localhost:5000'
    : 'https://api.bcash.com.br/service/createTransaction/xml/'
  ),
  Authorization  => $oAuth,
  Accept         => '*/*',
  'Content-Type' => "application/x-www-form-urlencoded;charset=ISO-8859-1",
  Content        => $query
);

my $ua  = LWP::UserAgent->new;
my $res = $ua->request($req);

warn $res->content;

fail();

done_testing();
