import{d as r,i as w,j as h,D as C,c as D,o as p,w as c,a as e,g as i,b as d,p as L,v as V,e as v,F as A,h as I,t as o,n as S}from"./app-w8r8lidQ.js";import{A as T}from"./AppLayout-B4YszN6Y.js";import{_ as j}from"./PrimaryButton-CjztJiG-.js";import{_ as N}from"./SecondaryButton-B1aPRVjH.js";import{_ as $}from"./TextInput-DsCrS9Ef.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const B={class:"p-6 bg-gray-100 min-h-screen"},P={class:"flex flex-col sm:flex-row justify-between mb-4 gap-4"},F={class:"flex items-center gap-2"},M={class:"overflow-x-auto bg-white p-4 rounded-lg shadow-md"},R={class:"w-full border-collapse"},H={class:"p-2"},K={class:"p-2"},U={class:"flex justify-between items-center mt-4"},z={class:"text-gray-700"},X={__name:"Mutation",setup(E){const u=r(w().props.transactions),m=r(""),n=r(10),l=r(1),g=h(()=>u.value.filter(a=>y(a).toLowerCase().includes(m.value.toLowerCase())).slice((l.value-1)*n.value,l.value*n.value)),f=a=>new Date(a).toLocaleDateString("id-ID",{day:"2-digit",month:"long",year:"numeric"}),b=a=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(a),y=a=>a.type==="income"?`Sumber: ${a.sub_kategori_id||"Tidak Ada"}`:`Kategori: ${a.sub_kategori_id||"Tidak Ada"}`,_=()=>{l.value>1&&l.value--},x=()=>{l.value*n.value<u.value.length&&l.value++};return(a,t)=>{const k=C("InputLabel");return p(),D(T,null,{default:c(()=>[e("div",B,[t[7]||(t[7]=e("h1",{class:"text-2xl font-bold mb-4 text-center text-gray-700"}," Riwayat Mutasi Rekening ",-1)),t[8]||(t[8]=e("div",{class:"bg-blue-100 p-4 rounded-md shadow-md mb-6"},[e("p",{class:"text-gray-700"},[i(" 💡 "),e("strong",null,"Catatan:"),i(" Halaman ini menampilkan semua transaksi masuk dan keluar dari rekening Anda. Anda dapat mencari transaksi tertentu dan menyesuaikan jumlah yang ditampilkan. ")])],-1)),e("div",P,[e("div",F,[d(k,{for:"entries",value:"Tampilkan"}),L(e("select",{"onUpdate:modelValue":t[0]||(t[0]=s=>n.value=s),class:"border p-2 rounded"},t[2]||(t[2]=[e("option",{value:"5"},"5",-1),e("option",{value:"10"},"10",-1),e("option",{value:"25"},"25",-1),e("option",{value:"50"},"50",-1)]),512),[[V,n.value]]),t[3]||(t[3]=e("span",{class:"text-gray-600"},"transaksi",-1))]),d($,{modelValue:m.value,"onUpdate:modelValue":t[1]||(t[1]=s=>m.value=s),type:"text",placeholder:"Cari transaksi...",class:"p-2 border rounded w-full sm:w-auto"},null,8,["modelValue"])]),e("div",M,[e("table",R,[t[4]||(t[4]=e("thead",null,[e("tr",{class:"bg-gray-200"},[e("th",{class:"p-2 text-left"},"Tanggal"),e("th",{class:"p-2 text-left"},"Keterangan"),e("th",{class:"p-2 text-left"},"Nominal")])],-1)),e("tbody",null,[(p(!0),v(A,null,I(g.value,s=>(p(),v("tr",{key:s.id,class:"border-b"},[e("td",H,o(f(s.date)),1),e("td",K,o(s.category)+" "+o(s.description),1),e("td",{class:S(["p-2 font-bold",s.type==="income"?"text-green-600":"text-red-600"])},o(b(s.amount)),3)]))),128))])]),e("div",U,[d(N,{onClick:_,disabled:l.value===1},{default:c(()=>t[5]||(t[5]=[i(" ⬅ Sebelumnya ")])),_:1},8,["disabled"]),e("span",z,"Halaman "+o(l.value),1),d(j,{onClick:x,disabled:l.value*n.value>=u.value.length},{default:c(()=>t[6]||(t[6]=[i(" Selanjutnya ➡ ")])),_:1},8,["disabled"])])])])]),_:1})}}};export{X as default};
