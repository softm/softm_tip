package kr.co.gscaltex.gsnpoint.util;

/**
 * ��ȣȭ���� �� ����� ���߱� ���� ���Ǵ� <br>
 * Padding�� �߻�ȭ �� Interface�̴�.
 */
public interface CryptoPadding {

	/**
	 * ��û�� Block Size�� ���߱� ���� Padding�� �߰��Ѵ�.<br>
	 * 
	 * @param source byte[] �е��� �߰��� bytes
	 * @param blockSize int block size
	 * @return byte[] �е��� �߰� �� ��� bytes
	 */
	public byte[] addPadding(byte[] source, int blockSize);
	
	/**
	 * ��û�� Block Size�� ���߱� ���� �߰� �� Padding�� �����Ѵ�.<br>
	 * 
	 * @param source byte[] �е��� ������ bytes
	 * @param blockSize int block size
	 * @return byte[] �е��� ���� �� ��� bytes
	 */
	public byte[] removePadding(byte[] source, int blockSize);
	
}
