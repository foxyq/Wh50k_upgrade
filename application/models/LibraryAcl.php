<?php

class Application_Model_LibraryAcl extends Zend_Acl
{
    public function __construct(){


        /**
         * RESOURCES - definition
         */
        //definicia login resource
        $this->add(new Zend_Acl_Resource('default:auth'));

        //definicia default resources - aby vedel Acl pracovat s pristupom kazdy controller musi tu byt definovany ako resource
        $this->add(new Zend_Acl_Resource('default:index'));
        $this->add(new Zend_Acl_Resource('default:error'));
        $this->add(new Zend_Acl_Resource('default:nastavenia'));
        $this->add(new Zend_Acl_Resource('default:profil'));

        //TRANSAKCIE resources
        $this->add(new Zend_Acl_Resource('default:prijmy'));
        $this->add(new Zend_Acl_Resource('default:vydaje'));
        $this->add(new Zend_Acl_Resource('default:ubytky'));
        $this->add(new Zend_Acl_Resource('default:externavyroba'));
        $this->add(new Zend_Acl_Resource('default:externadodavka'));
        $this->add(new Zend_Acl_Resource('default:spotreby'));
        $this->add(new Zend_Acl_Resource('default:inventury'));
        //LINUX srvr
        $this->add(new Zend_Acl_Resource('default:externa-vyroba'));
        $this->add(new Zend_Acl_Resource('default:externa-dodavka'));

        //OBJEDNAVKY
        $this->add(new Zend_Acl_Resource('default:objednavky'));
        $this->add(new Zend_Acl_Resource('default:mikroobjednavky'));
        //LINUX srvr
        $this->add(new Zend_Acl_Resource('default:mikro-objednavky'));


        //ADMINISTRACIA resources
        $this->add(new Zend_Acl_Resource('default:dodavatelia'));
        $this->add(new Zend_Acl_Resource('default:prepravci'));
        $this->add(new Zend_Acl_Resource('default:zakaznici'));
        $this->add(new Zend_Acl_Resource('default:sklady'));
        $this->add(new Zend_Acl_Resource('default:podsklady'));
        $this->add(new Zend_Acl_Resource('default:stroje'));
        $this->add(new Zend_Acl_Resource('default:materialydruhy'));
        $this->add(new Zend_Acl_Resource('default:materialytypy'));
        $this->add(new Zend_Acl_Resource('default:miestastiepenia'));
        $this->add(new Zend_Acl_Resource('default:motohodiny'));
        //LINUX srvr
        $this->add(new Zend_Acl_Resource('default:materialy-druhy'));
        $this->add(new Zend_Acl_Resource('default:materialy-typy'));
        $this->add(new Zend_Acl_Resource('default:miesta-stiepenia'));

        //definicia skladnik resources
        $this->add(new Zend_Acl_Resource('skladnik:index'));
        $this->add(new Zend_Acl_Resource('skladnik:profil'));
        $this->add(new Zend_Acl_Resource('skladnik:nastavenia'));

        //TRANSAKCIE resources
        $this->add(new Zend_Acl_Resource('skladnik:prijmy'));
        $this->add(new Zend_Acl_Resource('skladnik:vydaje'));

        /**
         * ROLES - definition
         * v Zend_Acl_Role by mohlo byt samotne meno role ale toto sa rychlejsie upravuje a vyjadruje to
         * hierarchiu. 1 je najvyssie a cim je cislo vacsie tym je hierarchicky nizsie. 1 dedi vsetkych - superadmin.
         */
        $skladnikRole = new Zend_Acl_Role('3');//skladnik
        $adminRole = new Zend_Acl_Role('2');//admin
        $superadminRole = new Zend_Acl_Role('1');//superAdmin

        $superadminsParents = array($skladnikRole, $adminRole);

        $this->addRole($skladnikRole);
        $this->addRole($adminRole);
        $this->addRole($superadminRole, $superadminsParents);


        /**
         * Assignment of resources to ROLES
         */
        /*
         *++++++++++++++
         *+ SUPERADMIN +
         *++++++++++++++
         */

        //tu netreba zatial nic definovat pretoze superAdmin dedi od ostatnych vsetko, mozno v buducnosti napr. page mapa apod.


        /*
         *+++++++++
         *+ ADMIN +
         *+++++++++
         */
        //transakcie
        $this->allow('2', 'default:index');
        $this->allow('2', 'default:prijmy');
        $this->allow('2', 'default:vydaje');
        $this->allow('2', 'default:ubytky');
        $this->allow('2', 'default:externadodavka');
        $this->allow('2', 'default:externavyroba');
        $this->allow('2', 'default:spotreby');
        $this->allow('2', 'default:inventury');
        //LINUX srvr
        $this->allow('2', 'default:externa-dodavka');
        $this->allow('2', 'default:externa-vyroba');


        //objednavky
        $this->allow('2', 'default:objednavky');
        $this->allow('2', 'default:mikroobjednavky');
        //LINUX srvr
        $this->allow('2', 'default:mikro-objednavky');

        //administracia
        $this->allow('2', 'default:dodavatelia');
        $this->allow('2', 'default:prepravci');
        $this->allow('2', 'default:zakaznici');
        $this->allow('2', 'default:sklady');
        $this->allow('2', 'default:podsklady');
        $this->allow('2', 'default:stroje');
        $this->allow('2', 'default:materialydruhy');
        $this->allow('2', 'default:materialytypy');
        $this->allow('2', 'default:nastavenia');
        $this->allow('2', 'default:profil');
        $this->allow('2', 'default:miestastiepenia');
        $this->allow('2', 'default:motohodiny');
        //LINUX srvr
        $this->allow('2', 'default:materialy-druhy');
        $this->allow('2', 'default:materialy-typy');
        $this->allow('2', 'default:miesta-stiepenia');

        /*
         *++++++++++++
         *+ SKLADNIK +
         *++++++++++++
         */
        $this->allow('3', 'skladnik:index');
        $this->allow('3', 'default:error');
        $this->allow('3', 'skladnik:prijmy');
        $this->allow('3', 'skladnik:vydaje');
        $this->allow('3', 'skladnik:profil');
        $this->allow('3', 'skladnik:nastavenia');

        //priradenie vsetkym prava na auth - login aj logout
        $this->allow(null, 'default:auth');


    }


}

