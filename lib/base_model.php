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
       
      }
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

  // validointi nimi-muuttujaan

  public function validate_name(){
    $errors = array();
    if($this->nimi == '' || $this->nimi == null){
      $errors[] = 'Nimi ei saa olla tyhjä!';
    }
    else if(strlen($this->nimi) < 3){
      $errors[] = 'Nimen pituuden tulla vähintään kolme merkkiä!';
    }

    return $errors;
  }  

  public function validate_address(){
    $errors = array();
    if($this->katuosoite == '' || $this->katuosoite == null){
      $errors[] = 'Katuosoite ei saa olla tyhjä!';
    }
    else if(strlen($this->katuosoite) < 3){
      $errors[] = 'Katuosoitteen pituuden tulla vähintään kolme merkkiä!';
    }

    return $errors;
  }

  public function validate_zipcode(){
    $errors = array();
    if($this->postinumero == '' || $this->postinumero == null){
      $errors[] = 'Postinumero on syötettävä!';
    }
    else if(ctype_digit($this->postinumero) && strlen($this->postinumero) == 5){
      
    } else {
      $errors[] = 'Postinumeron pituuden pitää olla viisi numeraalia!';
    }

    return $errors;
  }

  public function validate_city(){
    $errors = array();
    if($this->postitoimipaikka == '' || $this->postitoimipaikka == null){
      $errors[] = 'Postitoimipaikka on syötettävä!';
    }
    else if (strlen($this->postitoimipaikka) < 2){
      $errors[] = 'Postitoimipaikan pituus on oltava vähintään kaksi merkkiä';
    }
    return $errors; 

  }

  public function validate_phone(){
    $errors = array();
    if($this->puhelinnumero == '' || $this->puhelinnumero == null){
      $errors[] = 'Puhelinnumero on syötettävä!';
    }
    else if(ctype_digit($this->puhelinnumero) && strlen($this->puhelinnumero) > 4){
      
    } else {
      $errors[] = 'Puhelinnumeron pituuden pitää olla viisi numeraalia!';
    }

    return $errors;
  }

  public function validate_firstName(){
    $errors = array();
    if($this->etunimi == '' || $this->etunimi == null){
      $errors[] = 'Etunimi ei saa olla tyhjä!';
    }
    else if(strlen($this->etunimi) < 2){
      $errors[] = 'Etunimen pituuden tulla vähintään kaksi merkkiä!';
    }

    return $errors;
  }

  public function validate_surName(){
    $errors = array();
    if($this->sukunimi == '' || $this->sukunimi == null){
      $errors[] = 'Sukunimi ei saa olla tyhjä!';
    }
    else if(strlen($this->sukunimi) < 2){
      $errors[] = 'Sukunimen pituuden tulla vähintään kaksi merkkiä!';
    }

    return $errors;
  }

  public function validate_email(){
    $errors = array();
      if($this->email != '' || $this->email != null){
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Sähköpostiosoite on väärässä muodossa!";
      }
    }
    return $errors;
  }

}
