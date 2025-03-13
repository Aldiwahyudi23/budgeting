import{d as V,C as J,j as D,l as O,c as R,o as i,w as m,a as e,b as o,e as r,f as p,t as u,g as d,F as b,h,n as W,q as z,u as n,p as f,v as $,y as U,W as G}from"./app-DGnEmlNd.js";import{A as Q}from"./AppLayout-_irn6LmE.js";import{_ as X}from"./CustomModal-CX3Y0ott.js";import{_ as w}from"./PrimaryButton-83wIPzwK.js";import{_ as Y}from"./SecondaryButton-DmKw0fI0.js";import{_ as x}from"./InputLabel-BROOhc7p.js";import{_ as A}from"./TextInput-C9LZCotX.js";import{_ as y}from"./InputError-CmhsqWuJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const Z={class:"p-4"},tt={class:"container mx-auto p-2"},et={class:"flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2"},st={key:0,class:"mt-6 text-ligth hidden sm:block"},at={class:"flex items-center gap-2 mt-4 sm:mt-0"},nt={key:0},lt={class:"bg-white p-4 rounded-lg shadow-md"},ot=["onClick"],it={class:"text-gray-800"},rt={class:"text-purple-600 font-semibold"},ut={key:1,class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6"},dt={class:"flex items-center justify-between"},mt={class:"text-lg font-semibold"},pt={class:"text-gray-500 text-sm"},gt={class:"text-sm text-gray-500"},ct={class:"text-xl font-bold text-purple-600"},ft={key:0,class:"text-sm text-gray-500"},xt={key:1,class:"text-sm text-gray-500"},yt={key:2,class:"text-sm text-gray-500"},_t={key:3,class:"text-sm text-green-500"},vt={key:4,class:"text-sm text-blue-500"},kt={class:"mt-4 flex space-x-2"},bt={key:2,class:"text-center bg-white p-2 rounded-lg shadow-md"},ht={class:"mb-4"},wt={class:"mb-4"},Ct={class:"mb-4"},Ht={class:"mb-4"},Tt={key:0,class:"mb-4"},St=["value"],Vt={key:1,class:"mb-4"},Dt=["value"],$t={class:"mb-4"},Ut={class:"flex items-center"},At={class:"mb-4"},Bt={class:"flex items-center"},Mt={class:"mb-4"},jt={class:"flex items-center"},Nt={class:"flex justify-end mt-4"},Rt={__name:"Index",props:{debts:Array},setup(I){const C=I,H=V(!1),c=V(!1),_=V(!1),a=J({id:null,name:"",amount:"",note:"",type:"",due_date:null,tenor_months:null,is_active:!1,reminder:!1,auto:!1}),B=D(()=>C.debts.filter(l=>l.status==="active")),M=D(()=>C.debts.filter(l=>l.status!=="Active")),j=D(()=>C.debts.filter(l=>l.status==="paid")),v=l=>l?new Intl.NumberFormat("id-ID").format(l.replace(/\D/g,"")):"";O(()=>a.amount,l=>{a.amount=v(String(l))});const T=(l,t=null)=>{var s,g;c.value=l==="edit",c.value&&t?(a.id=t.id,a.name=((s=t.sub_category)==null?void 0:s.name)||"",a.note=t.note,a.amount=v(String(t.amount)),a.type=t.type,a.due_date=t.due_date,a.tenor_months=t.tenor_months,a.reminder=!!t.reminder,a.auto=!!t.auto,a.is_active=!!((g=t.sub_category)!=null&&g.is_active)):a.reset(),H.value=!0},k=()=>{a.reset(),H.value=!1},E=()=>{a.amount=a.amount.replace(/\D/g,""),c.value?a.put(route("debts.update",a.id),{onSuccess:()=>k()}):a.post(route("debts.store"),{onSuccess:()=>k()})},K=l=>{confirm("Apakah Anda yakin ingin menghapus hutang ini?")&&G.delete(route("debts.destroy",l))},F=l=>l?new Date(l).getDate():"",L=l=>l.type==="installment"&&l.expenses?`${l.expenses.length}-${l.tenor_months}`:"",N=()=>{_.value=!_.value};return(l,t)=>(i(),R(Q,{title:"Kelola Hutang"},{default:m(()=>[e("div",Z,[e("div",tt,[e("div",et,[e("div",null,[t[10]||(t[10]=e("h1",{class:"text-xl font-semibold text-gray-800"},"Kelola Hutang",-1)),t[11]||(t[11]=e("p",{class:"text-sm text-gray-600 mt-1"}," Halaman ini digunakan untuk mengelola dan menambahkan data hutang seperti hutang pribadi, cicilan, atau hutang bisnis. ",-1)),M.value.length>0?(i(),r("div",st,[e("a",{onClick:N,class:"text-sm text-blue-500 hover:text-blue-700 cursor-pointer"},u(_.value?"Sembunyikan Hutang Selesai":"Lihat Hutang Selesai"),1)])):p("",!0)]),e("div",at,[o(w,{onClick:t[0]||(t[0]=s=>T("create"))},{default:m(()=>t[12]||(t[12]=[d("Tambah Hutang")])),_:1}),M.value.length>0?(i(),r("a",{key:0,onClick:N,class:"text-sm text-blue-500 hover:text-blue-700 cursor-pointer sm:hidden text-right"},u(_.value?"Sembunyikan Hutang Selesai":"Lihat Hutang Selesai"),1)):p("",!0)])]),_.value&&j.value.length>0?(i(),r("div",nt,[t[13]||(t[13]=e("h2",{class:"text-lg font-semibold mb-4"},"Hutang yang Sudah Dibayar",-1)),e("div",lt,[(i(!0),r(b,null,h(j.value,s=>{var g;return i(),r("div",{key:s.id,class:"flex justify-between items-center py-2 border-b last:border-b-0 cursor-pointer hover:bg-gray-50",onClick:S=>T("detail",s)},[e("span",it,u(((g=s.sub_category)==null?void 0:g.name)||"Tanpa Kategori")+" ("+u(s.type)+")",1),e("span",rt,"Rp. "+u(v(s.amount)),1)],8,ot)}),128))])])):p("",!0),B.value.length>0?(i(),r("div",ut,[(i(!0),r(b,null,h(B.value,s=>{var g,S,P;return i(),r("div",{key:s.id,class:"bg-white p-6 rounded-lg shadow-md"},[e("div",dt,[e("h2",mt,[d(u(((g=s.sub_category)==null?void 0:g.name)||"Tanpa Kategori")+" ",1),e("span",pt,"("+u(s.type=="installment"?"Kredit/Cicilan":s.type)+")",1)]),e("span",{class:W(["px-2 py-1 text-xs font-semibold rounded-lg",(S=s.sub_category)!=null&&S.is_active?"bg-green-100 text-green-600":"bg-red-100 text-red-600"])},u((P=s.sub_category)!=null&&P.is_active?"Aktif":"Tidak Aktif"),3)]),e("p",gt,u(s.note),1),e("p",ct,"Rp. "+u(v(s.amount)),1),s.type==="personal"?(i(),r("p",ft," Pembayaran = "+u(v(s.paid_amount)),1)):p("",!0),s.type==="installment"?(i(),r("p",xt," Tenor = "+u(L(s)),1)):p("",!0),s.type==="installment"?(i(),r("p",yt,"Tanggal Jatuh Tempo: "+u(F(s.due_date)),1)):p("",!0),s.reminder?(i(),r("p",_t," Hutang ini di set Pengingat dan akan diingatkan selalu. ")):p("",!0),s.auto?(i(),r("p",vt," Setiap tanggal jatuh tempo, hutang akan otomatis tersimpan ke data. ")):p("",!0),e("div",kt,[o(w,{onClick:q=>T("edit",s)},{default:m(()=>t[14]||(t[14]=[d("Edit")])),_:2},1032,["onClick"]),o(w,{class:"bg-red-600 hover:bg-red-700",onClick:q=>K(s.id)},{default:m(()=>t[15]||(t[15]=[d("Hapus")])),_:2},1032,["onClick"])])])}),128))])):(i(),r("div",bt,t[16]||(t[16]=[e("p",{class:"text-gray-500 text-sm"},"Belum ada hutang yang tercatat. Silakan tambahkan hutang baru.",-1)]))),t[17]||(t[17]=e("div",{class:"mt-4 bg-gray-100 p-2 rounded-lg shadow-md"},[e("h2",{class:"text-lg font-semibold text-gray-800"},"Informasi Mengenai Hutang"),e("p",{class:"text-sm text-gray-600 mt-2"}," Halaman ini digunakan untuk mencatat hutang yang harus dibayar, baik itu hutang pribadi, cicilan, atau hutang bisnis. "),e("p",{class:"text-sm text-gray-600 mt-2"},[d(" Untuk pembayaran atau transaksi, silakan lakukan melalui halaman "),e("strong",null,"Transaksi Pengeluaran (Expenses)"),d(". Pilih kategori "),e("strong",null,"Hutang"),d(" dan tambahkan keterangan sesuai jenis hutang yang dibayarkan. ")])],-1))]),o(X,{show:H.value,title:c.value?"Edit Hutang":"Tambah Hutang",onClose:k},{content:m(()=>[e("form",{onSubmit:z(E,["prevent"])},[e("div",ht,[o(x,{for:"name"},{default:m(()=>t[18]||(t[18]=[d(" Nama Hutang "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),o(A,{id:"name",modelValue:n(a).name,"onUpdate:modelValue":t[1]||(t[1]=s=>n(a).name=s),class:"block w-full",disabled:c.value,readonly:c.value},null,8,["modelValue","disabled","readonly"]),o(y,{message:n(a).errors.name},null,8,["message"])]),e("div",wt,[o(x,{for:"amount"},{default:m(()=>t[19]||(t[19]=[d(" Nominal Hutang "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),o(A,{id:"amount",type:"number",modelValue:n(a).amount,"onUpdate:modelValue":t[2]||(t[2]=s=>n(a).amount=s),class:"block w-full"},null,8,["modelValue"]),o(y,{message:n(a).errors.amount},null,8,["message"])]),e("div",Ct,[o(x,{for:"note"},{default:m(()=>t[20]||(t[20]=[d(" Catatan ")])),_:1}),o(A,{id:"note",modelValue:n(a).note,"onUpdate:modelValue":t[3]||(t[3]=s=>n(a).note=s),class:"block w-full"},null,8,["modelValue"]),o(y,{message:n(a).errors.note},null,8,["message"])]),e("div",Ht,[o(x,{for:"type"},{default:m(()=>t[21]||(t[21]=[d(" Type Hutang "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),f(e("select",{id:"type","onUpdate:modelValue":t[4]||(t[4]=s=>n(a).type=s),class:"block w-full"},t[22]||(t[22]=[e("option",{disabled:"",value:""},"Pilih Tipe",-1),e("option",{value:"personal"},"Personal",-1),e("option",{value:"installment"},"Cicilan",-1)]),512),[[$,n(a).type]]),o(y,{message:n(a).errors.type},null,8,["message"])]),n(a).type==="installment"?(i(),r("div",Tt,[o(x,{for:"due_date"},{default:m(()=>t[23]||(t[23]=[d(" Tanggal Jatuh Tempo "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),f(e("select",{id:"due_date","onUpdate:modelValue":t[5]||(t[5]=s=>n(a).due_date=s),class:"block w-full",required:""},[(i(),r(b,null,h(31,s=>e("option",{key:s,value:s},u(s),9,St)),64))],512),[[$,n(a).due_date]]),o(y,{message:n(a).errors.due_date},null,8,["message"])])):p("",!0),n(a).type==="installment"?(i(),r("div",Vt,[o(x,{for:"tenor_months"},{default:m(()=>t[24]||(t[24]=[d(" Tenor (Bulan) "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),f(e("select",{id:"tenor_months","onUpdate:modelValue":t[6]||(t[6]=s=>n(a).tenor_months=s),class:"block w-full",required:""},[(i(),r(b,null,h(12,s=>e("option",{key:s,value:s},u(s),9,Dt)),64))],512),[[$,n(a).tenor_months]]),o(y,{message:n(a).errors.tenor_months},null,8,["message"])])):p("",!0),e("div",$t,[e("label",Ut,[f(e("input",{type:"checkbox","onUpdate:modelValue":t[7]||(t[7]=s=>n(a).is_active=s),class:"mr-2"},null,512),[[U,n(a).is_active]]),t[25]||(t[25]=e("span",null,"Status",-1))]),t[26]||(t[26]=e("p",{class:"text-sm text-gray-500"},"Jika Aktif akan bisa Transaksi",-1))]),e("div",At,[e("label",Bt,[f(e("input",{type:"checkbox","onUpdate:modelValue":t[8]||(t[8]=s=>n(a).reminder=s),class:"mr-2"},null,512),[[U,n(a).reminder]]),t[27]||(t[27]=e("span",null,"Pengingat",-1))]),t[28]||(t[28]=e("p",{class:"text-sm text-gray-500"},"Akan diingatkan H-1 dari Tanggal",-1))]),e("div",Mt,[e("label",jt,[f(e("input",{type:"checkbox","onUpdate:modelValue":t[9]||(t[9]=s=>n(a).auto=s),class:"mr-2"},null,512),[[U,n(a).auto]]),t[29]||(t[29]=e("span",null,"Otomatis",-1))]),t[30]||(t[30]=e("p",{class:"text-sm text-gray-500"},"Secara Otomatis Masuk data sesuai tanggal",-1))]),e("div",Nt,[o(Y,{type:"button",onClick:k},{default:m(()=>t[31]||(t[31]=[d("Batal")])),_:1}),o(w,{class:"ml-3",type:"submit"},{default:m(()=>[d(u(c.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{Rt as default};
