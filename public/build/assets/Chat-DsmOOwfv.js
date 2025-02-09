import{o as a,d as l,f as s,r as c,T as B,L as N,n as C,O as I,e as p,u,l as m,F as S,g as z,y as L,B as h,w as y,P as w,i as k,t as x}from"./vue-i18n-locales.generated-DazkPcQT.js";import{_ as b}from"./BaseButton-BhZf0EJx.js";import{_ as T}from"./FormInput-DeHhKyjW.js";import{_ as q}from"./Web3Auth-Dlv52QEo.js";import{c as H}from"./createLucideIcon-C3-ZXal3.js";import"./wagmi-CDY-DwX3.js";import"./sepolia-CvxlrZeJ.js";import"./blast-BTKMzCxo.js";import"./inherits_browser-BlS1d2rD.js";import"./SecondaryButton-CNsTjGHd.js";import"./PrimaryButton-CA1FRb4P.js";import"./useAccount-CGBMXWeW.js";import"./useConfig-BkRNL90S.js";import"./plugin-DEBxRKPP.js";import"./utils-DNJjGCm9.js";/**
 * @license lucide-vue-next v0.462.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const j=H("MessageSquareHeartIcon",[["path",{d:"M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z",key:"1lielz"}],["path",{d:"M14.8 7.5a1.84 1.84 0 0 0-2.6 0l-.2.3-.3-.3a1.84 1.84 0 1 0-2.4 2.8L12 13l2.7-2.7c.9-.9.8-2.1.1-2.8",key:"1blaws"}]]);function E(d,i){return a(),l("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true","data-slot":"icon"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"})])}const P={class:"flex flex-col h-[900px] bg-gray-850 p-4 rounded-lg shadow"},A={key:0,class:"w-full flex flex-col items-center justify-center h-full"},D={class:"p-8 bg-gray-800 rounded"},F={class:"overflow-y-auto pb-4 messages-container"},O={class:"flex items-start"},U=["src","alt"],Z={class:"text-sm font-semibold mb-1"},G={class:"text-sm"},J=["src","onClick"],K={class:"pt-4"},Q={class:"flex items-center space-x-4"},R={class:"flex-1"},me={__name:"Chat",props:{launchpadId:{type:Number,required:!0},devId:{type:Number,required:!0},initialMessages:{type:Array,default:()=>[]}},setup(d){const i=d,n=c([...i.initialMessages]),M=c(null),$=c(null),r=B({message:"",image_path:null,image_upload:!1,launchpad_id:i.launchpadId});N(()=>{window.Echo.channel(`launchpad.${i.launchpadId}`).listen("NewMessage",t=>{console.log(t),n.value.push(t.message),f()})});const f=()=>{C(()=>{const t=document.querySelector(".messages-container");t&&(t.scrollTop=t.scrollHeight)})},V=()=>{!r.message&&!r.image_path||r.post(window.route("msgs.store"),{preserveScroll:!0,onSuccess:()=>{r.reset(),M.value=null,$.value=null}})};return I(n,()=>{f()},{deep:!0}),(t,o)=>(a(),l("div",P,[n.value.length==0?(a(),l("div",A,[s("div",D,[p(u(j),{class:"w-16 h-16 stroke-[0.8]"}),o[1]||(o[1]=s("h3",{class:"text-xl font-extralight"},"No chat messages found",-1)),o[2]||(o[2]=s("h3",null,"Be the first to Leave a message",-1))])])):m("",!0),s("div",F,[(a(!0),l(S,null,z(n.value,e=>{var g,_,v;return a(),l("div",{key:e.uuid,class:w(["mb-4",{"flex justify-end":e.user_id===((g=t.$page.props.auth.user)==null?void 0:g.id)}])},[s("div",{class:w([{"bg-blue-100 dark:bg-blue-900":e.user_id===((_=t.$page.props.auth.user)==null?void 0:_.id),"bg-gray-100 dark:bg-gray-750":e.user_id!==((v=t.$page.props.auth.user)==null?void 0:v.id)},"rounded-lg p-3"])},[s("div",O,[s("img",{src:e.user.profile_photo_url,alt:e.user.name,class:"w-8 h-8 rounded-full mr-2"},null,8,U),s("div",null,[s("div",Z,[k(x(e.user.name||e.user.address.substring(0,6))+" ",1),e.user_id===d.devId?(a(),h(b,{key:0,class:"self-center ml-3 pointer-events-none",size:"xss",outlined:""},{default:y(()=>o[3]||(o[3]=[k(" DEV ")])),_:1})):m("",!0)]),s("p",G,x(e.message),1),e.image?(a(),l("img",{key:0,src:e.image,class:"mt-2 rounded-lg max-w-full h-auto",onClick:W=>t.$emit("image-click",e.image)},null,8,J)):m("",!0)])])],2)],2)}),128))]),s("div",K,[s("form",{onSubmit:L(V,["prevent"]),class:"space-y-4"},[s("div",Q,[s("div",R,[p(T,{modelValue:u(r).message,"onUpdate:modelValue":o[0]||(o[0]=e=>u(r).message=e),type:"text",size:"md",placeholder:"Type your message..."},null,8,["modelValue"])]),t.$page.props.auth.user?(a(),h(b,{key:0},{default:y(()=>[p(u(E),{class:"w-6 h-6"})]),_:1})):(a(),h(q,{key:1,size:"md"}))])],32)])]))}};export{me as default};
