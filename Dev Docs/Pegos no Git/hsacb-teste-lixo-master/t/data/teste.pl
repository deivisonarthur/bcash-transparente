use PHP::HTTPBuildQuery qw(http_build_query);
use Digest::MD5 qw(md5 md5_hex md5_base64);
use Time::HiRes qw(gettimeofday);
use MIME::Base64;
use PHP::Include; #  use PHP::Include ( DEBUG => 1 ); #If you would like to see diagnostic information on STDERR you will need to use this module slightly differently:
use warnings;
use strict;
use JSON;

my $consumerKey = '1f5c18f0e65699f2568ca2751654fa7fc5ce94b0';
my $sellerMail  = 'lojamodelo@pagamentodigital.com.br';

my $time        = time()*1000;
my $microtime   = gettimeofday();
my $rand        = rand();

my $signature   = {
oauth_consumer_key => $consumerKey, 
oauth_nonce => md5( $microtime . $rand ), 
oauth_signature_method => 'PLAINTEXT', 
oauth_timestamp => $time, 
oauth_version => '1.0', 
};
#print $signature;

#in order to use "http_build_query" command, at cmd/DOS type: ppm install PHP-HTTPBuildQuery
$signature = encode_base64(http_build_query($signature, '', '&'));
#print $signature;

my $oAuth  = {
'Authorization: OAuth realm' => 'https://api.bcash.com.br/service/createTransaction/xml/', 
oauth_consumer_key => $consumerKey,
oauth_nonce => md5( $microtime. $rand ),
oauth_signature => $signature,
oauth_signature_method => 'PLAINTEXT',
oauth_timestamp => $time,
oauth_version => 1.0,
'Content-Type:application/x-www-form-urlencoded',
charset => "UTF-8", 
};
#print $oAuth;


my $dados_object;

$dados_object->{products}->[0]->{code} = '1';
$dados_object->{products}->[0]->{description} = 'Teste';
$dados_object->{products}->[0]->{amount} = '1';
$dados_object->{products}->[0]->{value} = '0.01';
$dados_object->{products}->[0]->{extraDescription} = '';
$dados_object->{buyer}->[0]->{address}->{address} = 'a';
$dados_object->{buyer}->[0]->{address}->{number} = '1';
$dados_object->{buyer}->[0]->{address}->{complement} = 'sdasd';
$dados_object->{buyer}->[0]->{address}->{neighborhood} = 'aasda';
$dados_object->{buyer}->[0]->{address}->{city} = 'Cachoeirinha';
$dados_object->{buyer}->[0]->{address}->{state} = 'RS';
$dados_object->{buyer}->[0]->{address}->{zipCode} = '94970-825';
$dados_object->{buyer}->[0]->{mail} = 'teste_bcash@hotmail.com';
$dados_object->{buyer}->[0]->{name} = 'Teste Bcash';
$dados_object->{buyer}->[0]->{phone} = '5133258626';
$dados_object->{buyer}->[0]->{cellPhone} = '';
$dados_object->{buyer}->[0]->{gender} = 'M';
$dados_object->{buyer}->[0]->{birthDate} = '';
$dados_object->{buyer}->[0]->{cpf} = '12345678909';
$dados_object->{buyer}->[0]->{rg} = '';
$dados_object->{paymentMethod}->[0]->{code} = '1';
$dados_object->{creditCard}->[0]->{number} = '4111111111111111';
$dados_object->{creditCard}->[0]->{holder} = 'Teste Bcash';
$dados_object->{creditCard}->[0]->{maturityMonth} = '03';
$dados_object->{creditCard}->[0]->{maturityYear} = '2017';
$dados_object->{creditCard}->[0]->{securityCode} = '123';
$dados_object->{installments}->[0] = '9';
$dados_object->{sellerMail}->[0] = $sellerMail;
$dados_object->{orderId}->[0] = '';
$dados_object->{acceptedContract}->[0] = 'S';
$dados_object->{viewedContract}->[0] = 'S';

my $data = to_json( $dados_object );

print $data;

# include_php_vars( 'teste2.php' );

