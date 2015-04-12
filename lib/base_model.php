<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        $errors = array_merge($errors, $this->{$validator}());
        // ei toimi, saa poistaa -> $validator_errors[] = $this->{$validator}();
      }

      // ei toimi, saa poistaa -> $errors = array_merge($errors, $validator_errors);
      return $errors;
    }

    // yleinen validaattori

    public function validate_minimum_string_length($string, $length){
      $errors = array();
      if($string == '' || $string == null) {
        $errors[] = 'Syöte ei saa olla tyhjä!';
      }  
      if(strlen($string) < $length){
        $errors[] = 'Syöte on liian lyhyt!';
      }
      return $errors;

    // yleinen validaattori  

    }
    public function validate_exact_string_length($string, $length){
      $errors = array();
      if($string == '' || $string == null) {
        $errors[] = 'Syöte ei saa olla tyhjä!';
      } 
      if(strlen($string) != $length){
        $errors[] = 'Syöte on väärän pituinen!';
      }
      return $errors;
    }

  }
