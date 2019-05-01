<table>
    <thead>
    <tr>
        <th><b class="text-center">STT</b></th>
        <th><b class="text-center">Họ tên</b></th>
        <th><b class="text-center">Ngày sinh</b></th>
        <th><b class="text-center">Giới tính</b></th>
        <th><b class="text-center">Email</b></th>
        <th><b class="text-center">Số CMT</b></th>
        <th><b class="text-center">Dạng tật (theo quy định trong luật NKT)</b></th>
        <th><b class="text-center">Chi tiết tình trạng KT</b></th>
        <th><b class="text-center">Trình độ</b></th>
        <th><b class="text-center">Chuyên môn</b></th>
        <th><b class="text-center">Địa chỉ thường trú (Ghi rõ địa chỉ cụ thể)</b></th>
        <th><b class="text-center">Điện thoại liên hệ</b></th>
        <th><b class="text-center">Còn khả năng làm việc</b></th>
        <th><b class="text-center">Có việc làm (ghi cụ thể công việc)</b></th>
        <th><b class="text-center">Mức thu nhập (đồng/tháng)</b></th>
        <th><b class="text-center">Chăm sóc y tế, PHCN</b></th>
        <th><b class="text-center">Học văn hóa</b></th>
        <th><b class="text-center">Học nghề (Ghi rõ nghề gì)</b></th>
        <th><b class="text-center">Hỗ trợ sinh kế</b></th>
        <th><b class="text-center">Phổ biến thông tin</b></th>
        <th><b class="text-center">Đi lại, tiếp cận xây dựng</b></th>
        <th><b class="text-center">Hỗ trợ chính sách</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key => $user)
        @php
            $needIds = $user->userNeed->pluck('need_id')->toArray()
        @endphp
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->birthday }}</td>
            <td>{{ $user->gender === 'male' ? 'Nam' : 'Nữ' }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->identity_card }}</td>
            <td>{{ $user->userDisability->disability->name }}</td>
            <td>{{ $user->userDisability->detail }}</td>
            <td>{{ $user->academic_level }}</td>
            <td>{{ $user->specialize }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->labor_ability ? 'x' : '' }}</td>
            <td>{{ $user->employment_status ? $user->employment_status : '' }}</td>
            <td>{{ $user->income ? $user->income. ' vnđ' : '' }}</td>
            <td>{{ in_array(1, $needIds) ? 'x' : '' }}</td>
            <td>{{ in_array(2, $needIds) ? 'x' : '' }}</td>
            <td>{{ in_array(3, $needIds) ? 'x' : '' }}</td>
            <td>{{ in_array(4, $needIds) ? 'x' : '' }}</td>
            <td>{{ in_array(5, $needIds) ? 'x' : '' }}</td>
            <td>{{ in_array(6, $needIds) ? 'x' : '' }}</td>
            <td>{{ in_array(7, $needIds) ? 'x' : '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>