import{d as $,C as R,k as b,l as W,c as z,o as i,w as m,a as e,b as o,e as r,f as p,t as u,g as d,F as h,h as w,n as G,q as Q,u as l,p as f,v as A,y as U,W as X}from"./app-BfKwtCTL.js";import{A as Y}from"./AppLayout-DYgGF9Ha.js";import{_ as Z}from"./CustomModal-UbcvsL-s.js";import{_ as C}from"./PrimaryButton-DMlVQEDX.js";import{_ as tt}from"./SecondaryButton-D2CyLsTH.js";import{_ as x}from"./InputLabel-eknfm-FF.js";import{_ as B}from"./TextInput-D0KFhQtJ.js";import{_ as y}from"./InputError-89Sy7rr5.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const et={class:"p-4"},st={class:"container mx-auto p-2"},at={class:"flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2"},nt={key:0,class:"mt-6 text-ligth hidden sm:block"},lt={class:"flex items-center gap-2 mt-4 sm:mt-0"},ot={key:0},it={class:"bg-white p-4 rounded-lg shadow-md"},rt=["onClick"],ut={class:"text-gray-800"},dt={class:"text-purple-600 font-semibold"},mt={key:1,class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4"},pt={class:"flex items-center justify-between"},gt={class:"text-lg font-semibold"},ct={class:"text-gray-500 text-sm"},ft={class:"text-sm text-gray-500"},xt={class:"text-xl font-bold text-purple-600"},yt={key:0,class:"text-sm text-gray-500"},vt={key:1,class:"text-sm text-gray-500"},_t={key:2,class:"text-sm text-gray-500"},kt={key:3,class:"text-sm text-green-500"},bt={key:4,class:"text-sm text-blue-500"},ht={class:"mt-4 flex space-x-2"},wt={key:2,class:"text-center bg-white p-2 rounded-lg shadow-md mt-4"},Ct={class:"mb-4"},Ht={class:"mb-4"},Tt={class:"mb-4"},Vt={class:"mb-4"},St={key:0,class:"mb-4"},Dt=["value"],$t={key:1,class:"mb-4"},At=["value"],Ut={class:"mb-4"},Bt={class:"flex items-center"},It={class:"mb-4"},Mt={class:"flex items-center"},Nt={class:"mb-4"},Pt={class:"flex items-center"},jt={class:"flex justify-end mt-4"},zt={__name:"Index",props:{debts:Array},setup(E){const H=E,T=$(!1),c=$(!1),v=$(!1),a=R({id:null,name:"",amount:"",note:"",type:"",due_date:null,tenor_months:null,is_active:!1,reminder:!1,auto:!1}),I=b(()=>H.debts.filter(n=>n.status==="active")),M=b(()=>H.debts.filter(n=>n.status!=="active")),N=b(()=>H.debts.filter(n=>n.status==="paid")),_=n=>n?new Intl.NumberFormat("id-ID").format(n):"",K=n=>n?n.replace(/\./g,""):"",V=b({get:()=>_(a.amount),set:n=>{a.amount=K(n)}});W(()=>{V.value=_(a.amount)});const S=(n,t=null)=>{var s,g;c.value=n==="edit",c.value&&t?(a.id=t.id,a.name=((s=t.sub_category)==null?void 0:s.name)||"",a.note=t.note,a.amount=t.amount,a.type=t.type,a.due_date=t.due_date,a.tenor_months=t.tenor_months,a.reminder=!!t.reminder,a.auto=!!t.auto,a.is_active=!!((g=t.sub_category)!=null&&g.is_active)):a.reset(),T.value=!0},k=()=>{a.reset(),T.value=!1},F=()=>{a.amount=a.amount.replace(/\D/g,""),c.value?a.put(route("debts.update",a.id),{onSuccess:()=>k()}):a.post(route("debts.store"),{onSuccess:()=>k()})},L=n=>{confirm("Apakah Anda yakin ingin menghapus hutang ini?")&&X.delete(route("debts.destroy",n))},q=n=>n?new Date(n).getDate():"",J=n=>n.type==="installment"&&n.expenses?`${n.expenses.length}-${n.tenor_months}`:"",P=()=>{v.value=!v.value};return(n,t)=>(i(),z(Y,{title:"Kelola Hutang"},{default:m(()=>[e("div",et,[e("div",st,[e("div",at,[e("div",null,[t[10]||(t[10]=e("h1",{class:"text-xl font-semibold text-gray-800"},"Kelola Hutang",-1)),t[11]||(t[11]=e("p",{class:"text-sm text-gray-600 mt-1"}," Halaman ini digunakan untuk mengelola dan menambahkan data hutang seperti hutang pribadi, cicilan, atau hutang bisnis. ",-1)),M.value.length>0?(i(),r("div",nt,[e("a",{onClick:P,class:"text-sm text-blue-500 hover:text-blue-700 cursor-pointer"},u(v.value?"Sembunyikan Hutang Selesai":"Lihat Hutang Selesai"),1)])):p("",!0)]),e("div",lt,[o(C,{onClick:t[0]||(t[0]=s=>S("create"))},{default:m(()=>t[12]||(t[12]=[d("Tambah Hutang")])),_:1}),M.value.length>0?(i(),r("a",{key:0,onClick:P,class:"text-sm text-blue-500 hover:text-blue-700 cursor-pointer sm:hidden text-right"},u(v.value?"Sembunyikan Hutang Selesai":"Lihat Hutang Selesai"),1)):p("",!0)])]),v.value&&N.value.length>0?(i(),r("div",ot,[t[13]||(t[13]=e("h2",{class:"text-lg font-semibold mb-4"},"Hutang yang Sudah Dibayar",-1)),e("div",it,[(i(!0),r(h,null,w(N.value,s=>{var g;return i(),r("div",{key:s.id,class:"flex justify-between items-center py-2 border-b last:border-b-0 cursor-pointer hover:bg-gray-50",onClick:D=>S("detail",s)},[e("span",ut,u(((g=s.sub_category)==null?void 0:g.name)||"Tanpa Kategori")+" ("+u(s.type=="installment"?"Kredit/Cicilan":s.type)+")",1),e("span",dt,"Rp "+u(_(s.amount)),1)],8,rt)}),128))])])):p("",!0),I.value.length>0?(i(),r("div",mt,[(i(!0),r(h,null,w(I.value,s=>{var g,D,j;return i(),r("div",{key:s.id,class:"bg-white p-6 rounded-lg shadow-md"},[e("div",pt,[e("h2",gt,[d(u(((g=s.sub_category)==null?void 0:g.name)||"Tanpa Kategori")+" ",1),e("span",ct,"("+u(s.type=="installment"?"Kredit/Cicilan":s.type)+")",1)]),e("span",{class:G(["px-2 py-1 text-xs font-semibold rounded-lg",(D=s.sub_category)!=null&&D.is_active?"bg-green-100 text-green-600":"bg-red-100 text-red-600"])},u((j=s.sub_category)!=null&&j.is_active?"Aktif":"Tidak Aktif"),3)]),e("p",ft,u(s.note),1),e("p",xt,"Rp "+u(_(s.amount)),1),s.type==="personal"?(i(),r("p",yt," Pembayaran = "+u(_(s.paid_amount)),1)):p("",!0),s.type==="installment"?(i(),r("p",vt," Tenor = "+u(J(s)),1)):p("",!0),s.type==="installment"?(i(),r("p",_t,"Tanggal Jatuh Tempo: "+u(q(s.due_date)),1)):p("",!0),s.reminder?(i(),r("p",kt," Hutang ini di set Pengingat dan akan diingatkan selalu. ")):p("",!0),s.auto?(i(),r("p",bt," Setiap tanggal jatuh tempo, hutang akan otomatis tersimpan ke data. ")):p("",!0),e("div",ht,[o(C,{onClick:O=>S("edit",s)},{default:m(()=>t[14]||(t[14]=[d("Edit")])),_:2},1032,["onClick"]),o(C,{class:"bg-red-600 hover:bg-red-700",onClick:O=>L(s.id)},{default:m(()=>t[15]||(t[15]=[d("Hapus")])),_:2},1032,["onClick"])])])}),128))])):(i(),r("div",wt,t[16]||(t[16]=[e("p",{class:"text-gray-500 text-sm"},"Belum ada hutang yang tercatat. Silakan tambahkan hutang baru.",-1)]))),t[17]||(t[17]=e("div",{class:"mt-4 bg-gray-100 p-2 rounded-lg shadow-md"},[e("h2",{class:"text-lg font-semibold text-gray-800"},"Informasi Mengenai Hutang"),e("p",{class:"text-sm text-gray-600 mt-2"}," Halaman ini digunakan untuk mencatat hutang yang harus dibayar, baik itu hutang pribadi, cicilan, atau hutang bisnis. "),e("p",{class:"text-sm text-gray-600 mt-2"},[d(" Untuk pembayaran atau transaksi, silakan lakukan melalui halaman "),e("strong",null,"Transaksi Pengeluaran (Expenses)"),d(". Pilih kategori "),e("strong",null,"Hutang"),d(" dan tambahkan keterangan sesuai jenis hutang yang dibayarkan. ")])],-1))]),o(Z,{show:T.value,title:c.value?"Edit Hutang":"Tambah Hutang",onClose:k},{content:m(()=>[e("form",{onSubmit:Q(F,["prevent"])},[e("div",Ct,[o(x,{for:"name"},{default:m(()=>t[18]||(t[18]=[d(" Nama Hutang "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),o(B,{id:"name",modelValue:l(a).name,"onUpdate:modelValue":t[1]||(t[1]=s=>l(a).name=s),class:"block w-full",disabled:c.value,readonly:c.value},null,8,["modelValue","disabled","readonly"]),o(y,{message:l(a).errors.name},null,8,["message"])]),e("div",Ht,[o(x,{for:"amount"},{default:m(()=>t[19]||(t[19]=[d(" Nominal Hutang "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),o(B,{id:"amount",type:"text",modelValue:V.value,"onUpdate:modelValue":t[2]||(t[2]=s=>V.value=s),onInput:n.handleAmountInput,class:"block w-full"},null,8,["modelValue","onInput"]),o(y,{message:l(a).errors.amount},null,8,["message"])]),e("div",Tt,[o(x,{for:"note"},{default:m(()=>t[20]||(t[20]=[d(" Catatan ")])),_:1}),o(B,{id:"note",modelValue:l(a).note,"onUpdate:modelValue":t[3]||(t[3]=s=>l(a).note=s),class:"block w-full"},null,8,["modelValue"]),o(y,{message:l(a).errors.note},null,8,["message"])]),e("div",Vt,[o(x,{for:"type"},{default:m(()=>t[21]||(t[21]=[d(" Type Hutang "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),f(e("select",{id:"type","onUpdate:modelValue":t[4]||(t[4]=s=>l(a).type=s),class:"block w-full"},t[22]||(t[22]=[e("option",{disabled:"",value:""},"Pilih Tipe",-1),e("option",{value:"personal"},"Personal",-1),e("option",{value:"installment"},"Cicilan",-1)]),512),[[A,l(a).type]]),o(y,{message:l(a).errors.type},null,8,["message"])]),l(a).type==="installment"?(i(),r("div",St,[o(x,{for:"due_date"},{default:m(()=>t[23]||(t[23]=[d(" Tanggal Jatuh Tempo "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),f(e("select",{id:"due_date","onUpdate:modelValue":t[5]||(t[5]=s=>l(a).due_date=s),class:"block w-full",required:""},[(i(),r(h,null,w(31,s=>e("option",{key:s,value:s},u(s),9,Dt)),64))],512),[[A,l(a).due_date]]),o(y,{message:l(a).errors.due_date},null,8,["message"])])):p("",!0),l(a).type==="installment"?(i(),r("div",$t,[o(x,{for:"tenor_months"},{default:m(()=>t[24]||(t[24]=[d(" Tenor (Bulan) "),e("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),f(e("select",{id:"tenor_months","onUpdate:modelValue":t[6]||(t[6]=s=>l(a).tenor_months=s),class:"block w-full",required:""},[(i(),r(h,null,w(12,s=>e("option",{key:s,value:s},u(s),9,At)),64))],512),[[A,l(a).tenor_months]]),o(y,{message:l(a).errors.tenor_months},null,8,["message"])])):p("",!0),e("div",Ut,[e("label",Bt,[f(e("input",{type:"checkbox","onUpdate:modelValue":t[7]||(t[7]=s=>l(a).is_active=s),class:"mr-2"},null,512),[[U,l(a).is_active]]),t[25]||(t[25]=e("span",null,"Status",-1))]),t[26]||(t[26]=e("p",{class:"text-sm text-gray-500"},"Jika Aktif akan bisa Transaksi",-1))]),e("div",It,[e("label",Mt,[f(e("input",{type:"checkbox","onUpdate:modelValue":t[8]||(t[8]=s=>l(a).reminder=s),class:"mr-2"},null,512),[[U,l(a).reminder]]),t[27]||(t[27]=e("span",null,"Pengingat",-1))]),t[28]||(t[28]=e("p",{class:"text-sm text-gray-500"},"Akan diingatkan H-1 dari Tanggal",-1))]),e("div",Nt,[e("label",Pt,[f(e("input",{type:"checkbox","onUpdate:modelValue":t[9]||(t[9]=s=>l(a).auto=s),class:"mr-2"},null,512),[[U,l(a).auto]]),t[29]||(t[29]=e("span",null,"Otomatis",-1))]),t[30]||(t[30]=e("p",{class:"text-sm text-gray-500"},"Secara Otomatis Masuk data sesuai tanggal",-1))]),e("div",jt,[o(tt,{type:"button",onClick:k},{default:m(()=>t[31]||(t[31]=[d("Batal")])),_:1}),o(C,{class:"ml-3",type:"submit"},{default:m(()=>[d(u(c.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{zt as default};
