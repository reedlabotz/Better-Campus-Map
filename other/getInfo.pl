#!/usr/bin/perl
use warnings;
use strict;
use URI;
use Web::Scraper;



### SETTINGS ###

# website to scrape
my $urlToScrape = "http://illinois.edu/ricker/CampusMap";
my $urlBase = "http://illinois.edu/ricker/CampusMap?target=displayHighlight&buildingID=";

################





# the scrapers
my $buildings = scraper {
   process "#buildingID option", 'buildings[]' => 'TEXT';
   process "#buildingID option", 'ids[]' => '@value';
};

my $info = scraper {
   process "#buildingInfo", 'address' => 'HTML';
};




# scrape the departments
my $building_res = $buildings->scrape(URI->new($urlToScrape));
   
print "Building scrapper\n\n";
   
# file to open
open SEED, ">buildings.sql" or die $!;

# iterate through the departments
for my $i (0 .. $#{$building_res->{buildings}}) {
   
   
   my $name = escape($building_res->{buildings}[$i]);
   my $id = $building_res->{ids}[$i];
   eval { 
   
      print "$name\n";
      my $url = $urlBase.$id;
      my $info_res = $info->scrape(URI->new($url));
   
      my $address = escape($info_res->{address});
      my @addressSplit = split('</h3>',$address);
      my $address1 = $addressSplit[1];
      my @addressSplit1 = split("<br /><br />",$address1);
      my $address2 = $addressSplit1[0];
      print "   -$address2\n";
      
      print SEED "INSERT INTO buildings (name,address) VALUES ('$name','$address2');\n";
   
      sleep(1);
   } or do{
      print "   -ERROR: 404!!!\n";
   }
}

close SEED;

sub escape
{
   my $string = shift;
   $string=~ s/'/''/g;
   return $string;
}


sub trim
{
	my $string = shift;
	$string =~ s/^\s+//;
	$string =~ s/\s+$//;
	return $string;
}