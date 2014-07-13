20140713 irforum-v3.08

このプログラムは、藤原 慎太郎 が作成しました。
今のところ、ユーザーのオンライン登録(メール送信を含む)、管理者画面における一覧表示・検索機能を持っています。
管理者画面からのログアウト機能もあります。
管理者の追加要領は、一番下で説明しています。

著作権は作者にあります。
また、Zend Technologies USA, Inc.のフレームワークを使っていますの、そちらにも著作権があります。

このプログラムは、PHPで書かれています。
jQuery及びjavascriptを使用しています。

このプログラムの使用については、使用者が自己責任で使用するものとします。
このプログラムの使用により被ったどんな損害についても作者は責任がないものとします。
ライセンスは、修正BSDライセンスとします。

ライセンスに関する記述です。

//////////////////////////////////////////////////////////////////////////////////
Copyright (c) 2005-2014, Zend Technologies USA, Inc.
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.

    * Redistributions in binary form must reproduce the above copyright notice,
      this list of conditions and the following disclaimer in the documentation
      and/or other materials provided with the distribution.

    * Neither the name of Zend Technologies USA, Inc. nor the names of its
      contributors may be used to endorse or promote products derived from this
      software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
//////////////////////////////////////////////////////////////////////////////////

インターネット上のサーバでの使用を前提としています。
httpsプロトコルでの通信を前提としています。
通信経路の暗号化のために、apacheのrewriteモジュール等を使用して下さい。
特にネット上のjQueryを参照するので、スタンドアロン端末では動きません。
スタンドアロン端末で動かす場合は、jQueryをダウンロードしリンク先を必要な記述に変えてください。

作成はZend Framework2、 Bourne Shellおよびvimを使用しました。
データベースは、PostgreSQLですが、一部の制約の記述をあわせればその他のRDBで動きます。
ZendFrameworkを勉強してください。
//////////////////////////////////////////////////////////////////
以下の2つのファイルを添付しています。
データベースを作成後、それぞれテーブルに取り込みます。
pref.csv(県名リストファイル)
zipJp.csv(郵便番号と住所の関係ファイル)
//////////////////////////////////////////////////////////////////
データベースはPostgreSQLで作成しました。
作成した6つのテーブルとsequenceについて説明します。

データベース名はirforum です。
テーブルはconfigs,forum,iruser,password,pref,zip の6つです。
sequenceを2つつくっています。
irforum=# \d
              List of relations
 Schema |     Name     |   Type   |  Owner   
--------+--------------+----------+----------
 public | configs      | table    | postgres
 public | forum        | table    | postgres
 public | forum_id_seq | sequence | postgres
 public | iruser       | table    | postgres
 public | password     | table    | postgres
 public | pref         | table    | postgres
 public | user_id_seq  | sequence | postgres
 public | zip          | table    | postgres
(8 rows)

///////////////////////////////////
configsテーブルは、以下のコマンドで作成できます。

#create table configs(config_id integer primary key, title varchar(30), description varchar(300), copyright varchar(50));

irforum=# \d configs
              Table "public.configs"
   Column        |          Type          | Modifiers 
-----------------+------------------------+-----------
 config_id       | integer                | not null
 title           | character varying(30)  | not null
 description     | character varying(300) | 
 keywords        | character varying(100) | 
 contents_title  | character varying(100) | 
 copyright       | character varying(50)  | 
Indexes:
    "configs_pkey" PRIMARY KEY, btree (config_id)

///////////////////////////////////
prefテーブルは、以下のコマンドで作成できます。

#create table pref(pref_id integer primary key, pref_name_kanji varchar(10), pref_name_yomi varchar(30));

prefテーブルは、県名を入れているものです。県のファイルをcsvで用意してあります。
これを次のようなcopyコマンドでテーブルにコピーしてください。
-irforum #copy pref from '/var/lib/pgsql/pref.csv' WITH CSV;

irforum=# \d pref
                 Table "public.pref"
     Column      |         Type          | Modifiers 
-----------------+-----------------------+-----------
 pref_id         | integer               | not null
 pref_name_kanji | character varying(10) | 
 pref_name_yomi  | character varying(30) | 
Indexes:
    "pref_pkey" PRIMARY KEY, btree (pref_id)
Referenced by:
    TABLE "iruser" CONSTRAINT "iruser_pref_id_fkey" FOREIGN KEY (pref_id) REFERENCES pref(pref_id)

///////////////////////////////////
zipテーブルは、以下のコマンドで作成できます。

#create table zip(zip_id integer primary key,zip_first integer not null,zip_last integer not null,pref_id integer references pref(pref_id),city varchar(300) not null,town varchar(300) not null);

zipテーブルは、郵便番号と住所の対応表を入れているものです。ファイルをcsvで用意してあります。
これを次のようなcopyコマンドでテーブルにコピーしてください。
-irforum #copy zip from '/var/lib/pgsql/zipJp.csv' WITH CSV;

irforum=# \d zip
               Table "public.zip"
  Column   |          Type          | Modifiers 
-----------+------------------------+-----------
 zip_id    | integer                | not null
 zip_first | integer                | not null
 zip_last  | integer                | not null
 pref_id   | integer                | 
 city      | character varying(300) | not null
 town      | character varying(300) | not null
Indexes:
    "zip_pkey" PRIMARY KEY, btree (zip_id)
Foreign-key constraints:
    "zip_pref_id_fkey" FOREIGN KEY (pref_id) REFERENCES pref(pref_id)

///////////////////////////////////
sequenceは、以下のコマンドで作成できます。
#create sequence user_id_seq;
#create sequence forum_id_seq;
///////////////////////////////////
forumテーブルは、以下のコマンドで作成できます。
sequence で採番できるようにして、次のようになります。
#create table forum(forum_id bigint primary key, date date not null unique,actie integer not null default 0);
active列は、フォーラムの有効化、無効化を表しています。
変更の際は、いったん無効化(0)してから行い、再び有効化してください。
有効化できるのは、ただ一つのフォーラムのみです。
登録ユーザーは、どれかのフォーラムに関連づけられます。

irforum=# \d forum
                          Table "public.forum"
  Column  |  Type          |                     Modifiers                      
----------+----------------+----------------------------------------------------
 forum_id | bigint         | not null default nextval('forum_id_seq'::regclass)
 date     | date           | not null
 title    | varchar(40)    | not null
 active   | integer        | default 0 
Indexes:
    "forum_pkey" PRIMARY KEY, btree (forum_id)
    "c1" UNIQUE CONSTRAINT, btree (date)
///////////////////////////////////
iruserテーブルは、以下のコマンドで作成できます。
primary key に2つのカラムを指定しています。
これにより、異なるフォーラムへの同一ユーザ（同一メールアドレス）の登録が可能になります。 

#create table iruser(user_id bigint,surname varchar(50) not null,firstname varchar(50) not null,surname_yomi varchar(100) not null,firstname_yomi varchar(100) not null,zip_first varchar(3) not null,zip_last varchar(4) not null,pref_id integer references pref(pref_id),city varchar(100) not null,town varchar(100), building varchar(100),phone_first varchar(5) not null, phone_second varchar(4) not null, phone_third varchar(4) not null,email varchar(100) unique not null,forum_id bigint references forum(forum_id),primary key(email,forumid));

pref_idは、prefテーブルのpref_idへの外部キーです。
forum_idは、forumテーブルのforum_idへの外部キーです。
これにより、登録ユーザーは、どれかのフォーラムに関連づけられます。

irforum=# \d iruser
                                    Table "public.iruser"
     Column     |          Type          |                     Modifiers                     
----------------+------------------------+---------------------------------------------------
 user_id        | bigint                 | not null default nextval('user_id_seq'::regclass)
 surname        | character varying(50)  | not null
 firstname      | character varying(50)  | not null
 surname_yomi   | character varying(100) | not null
 firstname_yomi | character varying(100) | not null
 zip_first      | character varying(3)   | not null
 zip_last       | character varying(4)   | not null
 pref_id        | integer                | 
 city           | character varying(100) | not null
 town           | character varying(100) | 
 building       | character varying(100) | 
 phone_first    | character varying(5)   | not null
 phone_second   | character varying(4)   | not null
 phone_third    | character varying(4)   | not null
 email          | character varying(100) | not null
 forum_id       | bigint                 | 
Indexes:
    "iruser_pkey" PRIMARY KEY, btree (email,forum_id)
Foreign-key constraints:
    "iruser_forum_id_fkey" FOREIGN KEY (forum_id) REFERENCES forum(forum_id)
    "iruser_pref_id_fkey" FOREIGN KEY (pref_id) REFERENCES pref(pref_id)
//////////////////////////////////////////////////////////////////////////////
テーブルが、sequence で自動採番するようにします。

#alter table iruser alter column user_id set default nextval('user_id_seq');
#alter table iruser alter column forum_id set default nextval('forum_id_seq');
/////////////////////////////////////////////////////////////////////////////
passwordテーブルは、以下のコマンドで作成できます。
#create table password(login_name varchar(32) primary key, password varchar(60) not null);

password カラムには、暗号化されたデータが入ります。ぴったり60バイトですので、そうしておきます。

irforum=# \d password
            Table "public.password"
   Column   |         Type          | Modifiers 
------------+-----------------------+-----------
 login_name | character varying(32) | not null
 password   | character varying(60) | not null
Indexes:
    "password_pkey" PRIMARY KEY, btree (login_name)

/////////////////////////////////////////////////////////////////////////////////////////////
apacheがテーブルを操作できるように、以下のように権限を付与しています。
#grant all on configs to public;
#grant all on pref to public;
#grant all on zip to public;
#grant all on iruser to public;
#grant all on forum to public;
////////////////////////////////////////////////////////////////////////////////////////////
管理者を追加する方法は、パスワード関連のクラスファイルPasswordController.phpを正しく設定・保存し、アクセスirforum/application/password/addすれば、自動的にテーブルに暗号化されて追加されます。

以上です
