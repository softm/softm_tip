/**
 * ==================================================================
 *
 * (주)포이시스., Software License, Version 1.0
 *
 * Copyright (c) 2008 (주)포이시스.,
 * 서울 금천구 가산동 371-28 우림라이온스밸리 B동 1412호
 * All rights reserved.
 *
 * DON'T COPY OR REDISTRIBUTE THIS SOURCE CODE WITHOUT PERMISSION.
 * THIS SOFTWARE IS PROVIDED ''AS IS'' AND ANY EXPRESSED OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL (주)포이시스 OR ITS
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF
 * USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, \
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT
 * OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 * ====================================================================
 *
 * For more information on this product, please see
 * http://www.foresys.co.kr
 *
 */

/*
 * @(#)AmmemberInfo.java 1.10 2009. 07. 16
 */

package kr.co.loan.dto;

import org.springframework.stereotype.Component;


/**
 * AmmemberInfo.java
 *
 * @version @(#)AmmemberInfo.java 1.10 2009. 07. 16
 * @author 차용진(yong-Jin, Cha)
 * @modified
 */


@Component
public class AmmemberInfo {

	private String member_no = "";			// 사번
	private String ars_no="";
	private String direct_no="";
	private String member_nm = "";			// 사원명
	private String member_pw = "";			// 비번
	private String member_mac = "";			// IP
	private String role_cd = "";			// 역할 코드
	private String role_nm = "";			// 역할명
	private String position = "";			// 직급
	private String position_nm = "";		// 직급
	private String member_state = "";		// 상태
	private String mobile_no = "";			// 휴대폰
	private String bank_cd = "";			// 은행코드
	private String bank_nm = "";			// 은행명
	private String branch_cd = "";			// 지점코드
	private String branch_nm = "";			// 지점명
	private String dept_cd = "";			// 부서코드
	private String dept_nm = "";			// 부서명
	private String dept_job = "";			// 담당업무
	private String allot_cd = "";			// 

	private String agt_stat = "";			// 상담원상
	private String agt_role = "";			// 상담원업무역할
	private String agt_cti = "";			// 상담원구분
	private String agt_phone = "";			// 내선번호
	private String api_phone = "";			// 내선번호
	private String agt_group = "";			// 업무그룹
	private String agt_dtel = "";			// 직통DID 번호
	private String agt_etel = "";			// 기타전화
	private String agt_excel = "";			// excel 사용여부
	private String cti_chk = "";			// 상담원구분

	private String login_seq = "";	// 로그인일련번호
	private String login_time = "";			// 로그인시간
	private String service_check = "";		//
	private String service = "";			//
	private String service_cd = "";			//

	private String ifis_pwd = "";			//
	private String ifis_ip = "";			//
	private String ifis_daily_yn = "";			//
	private String ifis_loan_yn = "";			//
	private String terminal_no = "";			//
	private String member_idno = "";			//
	private String sms_tel_no1 = "";			// SMS_수신번호1
	private String sms_tel_no2 = "";			// SMS_수신번호2
	private String sms_tel_no3 = "";			// SMS_수신번호3
	private String grid_view = "";				//
	private String rec_type = "";				//
	private String loanreq_seq = "";			//
	private String team_cd = "";			//
	private String site_cd = "";			//사이트코드 
	private String role_job = "";			//역할업체구분
	
	private String Ifis_opt_no = "";		// 조작자 번호

	public String getLoanreq_seq() {		return loanreq_seq;	}
	public void setLoanreq_seq(String loanreq_seq) {		this.loanreq_seq = loanreq_seq;	}
	public String getSms_tel_no1() {		return sms_tel_no1;	}
	public String getSms_tel_no2() {		return sms_tel_no2;	}
	public String getSms_tel_no3() {		return sms_tel_no3;	}
	public String getMember_no() {				return member_no;	}

	public String getMember_nm() {				return member_nm;	}
	public String getMember_mac() {				return member_mac;	}
	public String getRole_cd() {				return role_cd;	}
	public String getRole_nm() {				return role_nm;	}
	public String getPosition() {				return position;	}
	public String getPosition_nm() {			return position_nm;	}
	public String getMobile_no() {				return mobile_no;	}
	public String getBank_cd() {				return bank_cd;	}
	public String getBank_nm() {				return bank_nm;	}
	public String getBranch_cd() {				return branch_cd;	}
	public String getBranch_nm() {				return branch_nm;	}
	public String getDept_cd() {				return dept_cd;	}
	public String getDept_nm() {				return dept_nm;	}
	public String getDept_job() {				return dept_job;	}
	public String getAgt_stat() {				return agt_stat;	}
	public String getAgt_role() {				return agt_role;	}
	public String getAgt_cti() {				return agt_cti;	}
	public String getApi_phone() {				return api_phone;	}
	public String getAgt_dtel() {				return agt_dtel;	}
	public String getAgt_etel() {				return agt_etel;	}
	public String getAgt_excel() {				return agt_excel;	}
	public String getLogin_seq() {		return login_seq;	}
	public String getLogin_time() {				return login_time;	}
	public String getService_check() {			return service_check;	}
	public String getService() {				return service;	}
	public String getMember_state() {			return member_state;	}
	public String getIfis_daily_yn() {		return ifis_daily_yn;	}
	public String getIfis_loan_yn() {		return ifis_loan_yn;	}
	public String getIfis_pwd() {		return ifis_pwd;	}
	public String getTerminal_no() {		return terminal_no;	}
	public String getMember_idno() {		return member_idno;	}
	public String getAgt_phone() {		return agt_phone;	}
	public String getCti_chk() {		return cti_chk;	}
	public String getAgt_group() {		return agt_group;	}
	public String getIfis_ip() {		return ifis_ip;	}
	public String getGrid_view() {				return grid_view;	}
	public String getTeam_cd() {				return team_cd;	}
	public String getSite_cd() {		return site_cd;	}
	public String getRole_job() {		return role_job;	}
	public String getAllot_cd() {		return allot_cd;	}
	
	public void setAllot_cd(String allot_cd) {		this.allot_cd = allot_cd;	}
	public void setSite_cd(String site_cd) {		this.site_cd = site_cd;	}
	public void setRole_job(String role_job) {		this.role_job = role_job;	}
	public void setMember_no(String member_no) {		this.member_no = member_no;	}
	public void setMember_nm(String member_nm) {		this.member_nm = member_nm;	}
	public void setMember_mac(String member_mac) {		this.member_mac = member_mac;	}
	public void setRole_cd(String role_cd) {			this.role_cd = role_cd;	}
	public void setRole_nm(String role_nm) {			this.role_nm = role_nm;	}
	public void setPosition(String position) {			this.position = position;	}
	public void setPosition_nm(String position_nm) {	this.position_nm = position_nm;	}
	public void setMobile_no(String mobile_no) {		this.mobile_no = mobile_no;	}
	public void setBank_cd(String bank_cd) {			this.bank_cd = bank_cd;	}
	public void setBank_nm(String bank_nm) {			this.bank_nm = bank_nm;	}
	public void setBranch_cd(String branch_cd) {		this.branch_cd = branch_cd;	}
	public void setBranch_nm(String branch_nm) {		this.branch_nm = branch_nm;	}
	public void setDept_cd(String dept_cd) {			this.dept_cd = dept_cd;	}
	public void setDept_nm(String dept_nm) {			this.dept_nm = dept_nm;	}
	public void setDept_job(String dept_job) {			this.dept_job = dept_job;	}
	public void setAgt_stat(String agt_stat) {			this.agt_stat = agt_stat;	}
	public void setAgt_role(String agt_role) {			this.agt_role = agt_role;	}
	public void setAgt_cti(String agt_cti) {			this.agt_cti = agt_cti;	}
	public void setApi_phone(String api_phone) {		this.api_phone = api_phone;	}
	public void setAgt_dtel(String agt_dtel) {			this.agt_dtel = agt_dtel;	}
	public void setAgt_etel(String agt_etel) {			this.agt_etel = agt_etel;	}
	public void setAgt_excel(String agt_excel) {		this.agt_excel = agt_excel;	}
	public void setLogin_seq(String login_seq) {		this.login_seq = login_seq;	}
	public void setLogin_time(String login_time) {					this.login_time = login_time;	}
	public void setService_check(String service_check) {			this.service_check = service_check;	}
	public void setService(String service) {						this.service = service;	}
	public void setMember_state(String member_state) {		this.member_state = member_state;	}
	public void setIfis_daily_yn(String ifis_daily_yn) {		this.ifis_daily_yn = ifis_daily_yn;	}
	public void setIfis_loan_yn(String ifis_loan_yn) {		this.ifis_loan_yn = ifis_loan_yn;	}
	public void setIfis_pwd(String ifis_pwd) {		this.ifis_pwd = ifis_pwd;	}
	public void setTerminal_no(String terminal_no) {		this.terminal_no = terminal_no;	}
	public void setMember_idno(String member_idno) {		this.member_idno = member_idno;	}
	public void setSms_tel_no1(String sms_tel_no1) {		this.sms_tel_no1 = sms_tel_no1;	}
	public void setSms_tel_no2(String sms_tel_no2) {		this.sms_tel_no2 = sms_tel_no2;	}
	public void setSms_tel_no3(String sms_tel_no3) {		this.sms_tel_no3 = sms_tel_no3;	}
	public void setAgt_phone(String agt_phone) {		this.agt_phone = agt_phone;	}
	public void setCti_chk(String cti_chk) {		this.cti_chk = cti_chk;	}
	public void setAgt_group(String agt_group) {		this.agt_group = agt_group;	}
	public void setIfis_ip(String ifis_ip) {		this.ifis_ip = ifis_ip;	}
	public void setGrid_view(String grid_view) {		this.grid_view = grid_view;	}
	public String getMember_pw() {		return member_pw;	}
	public void setMember_pw(String member_pw) {		this.member_pw = member_pw;	}
	public String getService_cd() {
		return service_cd;
	}
	
	public String getArs_no() {		return ars_no;	}
	public String getDirect_no() {		return direct_no;	}

	
	
	public void setArs_no(String ars_no) {		this.ars_no = ars_no;	}
	public void setDirect_no(String direct_no) {		this.direct_no = direct_no;	}
	
	
	public void setTeam_cd(String team_cd) {
		this.team_cd = team_cd;
	}	
	public void setService_cd(String service_cd) {
		this.service_cd = service_cd;
	}
	public String getRec_type() {
		return rec_type;
	}
	public void setRec_type(String rec_type) {
		this.rec_type = rec_type;
	}
	public String getIfis_opt_no() {
		return Ifis_opt_no;
	}
	public void setIfis_opt_no(String ifis_opt_no) {
		Ifis_opt_no = ifis_opt_no;
	}


}
