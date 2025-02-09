import{T as A,d as O,f as d,i as p,e as s,u as r,w as f,o as u,B as k,l as R}from"./vue-i18n-locales.generated-DazkPcQT.js";import{_ as l}from"./FormInput-DeHhKyjW.js";import{L as E}from"./Loading-C3NjX0uh.js";import{_ as S}from"./PrimaryButton-CA1FRb4P.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const c={class:"grid gap-4"},x={__name:"LaravelPostmark",props:{postmark:Object,mailer:Object},setup(M){var m,i,n;const t=M,e=A({MAIL_MAILER:"postmark",POSTMARK_TOKEN:(m=t.postmark)==null?void 0:m.token,MAIL_FROM_ADDRESS:(i=t.mailer)==null?void 0:i.address,MAIL_FROM_NAME:(n=t.mailer)==null?void 0:n.name}),_=()=>{e.put(window.route("admin.settings.mail",{mailer:"postmark"}),{preserveScroll:!0,preserveState:!0})};return(L,a)=>(u(),O("div",c,[a[4]||(a[4]=d("p",{class:"font-semibold py-3 text-sm text-primary"},[p(" Get your credentials "),d("a",{class:"text-sky-400 hover:text-sky-500 ml-1",href:"https://postmarkapp.com/"}," Here ")],-1)),s(l,{label:"Universal Email from Address",class:"max-w-lg",error:r(e).errors.MAIL_FROM_ADDRESS,modelValue:r(e).MAIL_FROM_ADDRESS,"onUpdate:modelValue":a[0]||(a[0]=o=>r(e).MAIL_FROM_ADDRESS=o)},null,8,["error","modelValue"]),s(l,{label:"Universal Email from Name",error:r(e).errors.MAIL_FROM_NAME,modelValue:r(e).MAIL_FROM_NAME,"onUpdate:modelValue":a[1]||(a[1]=o=>r(e).MAIL_FROM_NAME=o)},null,8,["error","modelValue"]),s(l,{label:"Postmark Api Token",error:r(e).errors.POSTMARK_TOKEN,modelValue:r(e).POSTMARK_TOKEN,"onUpdate:modelValue":a[2]||(a[2]=o=>r(e).POSTMARK_TOKEN=o)},null,8,["error","modelValue"]),s(S,{disabled:r(e).processing,onClick:_,class:"w-full mt-4",primary:""},{default:f(()=>[r(e).processing?(u(),k(E,{key:0,class:"mr-2 -ml-1"})):R("",!0),a[3]||(a[3]=p(" Save Postmark Settings "))]),_:1},8,["disabled"])]))}};export{x as default};
