import{A as c}from"./AppLayout-CZpKmfOJ.js";import{c as l,o as e,w as p,a as r,e as s,f as a,b as o}from"./app-DMOSpIva.js";/* empty css                                                                       */import u from"./LogoutOtherBrowserSessionsForm-3Oktun1B.js";import{S as i}from"./SectionBorder-CQcmA5q-.js";import f from"./TwoFactorAuthenticationForm-Bm5gTdKL.js";import d from"./UpdatePasswordForm-DFyuACIk.js";import h from"./UpdateProfileInformationForm-CmMGZPEY.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./ActionMessage-B2eDl9MX.js";import"./DialogModal-qHmDFpcj.js";import"./SectionTitle-WUSA6tFS.js";import"./InputError-Duae4cza.js";import"./PrimaryButton-D3g5zZMV.js";import"./SecondaryButton-Cup7mcwO.js";import"./TextInput-BhKf-tHw.js";import"./DangerButton-Bx69BfWo.js";import"./InputLabel-C9C-EeLH.js";import"./FormSection-CkwMF8sr.js";const _={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},g={key:0},w={key:1},x={key:2},I={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(m){return(t,n)=>(e(),l(c,{title:"Profile"},{header:p(()=>n[0]||(n[0]=[r("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1)])),default:p(()=>[r("div",null,[r("div",_,[t.$page.props.jetstream.canUpdateProfileInformation?(e(),s("div",g,[o(h,{user:t.$page.props.auth.user},null,8,["user"]),o(i)])):a("",!0),t.$page.props.jetstream.canUpdatePassword?(e(),s("div",w,[o(d,{class:"mt-10 sm:mt-0"}),o(i)])):a("",!0),t.$page.props.jetstream.canManageTwoFactorAuthentication?(e(),s("div",x,[o(f,{"requires-confirmation":m.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),o(i)])):a("",!0),o(u,{sessions:m.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"])])])]),_:1}))}};export{I as default};
