<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookDetail;
use App\Models\Donvi;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Input;

class BookController extends Controller
{
    public function get_danh_sach_co_quan(Request $request) {
        // get data
        $books = Book::getList()->get();

        // view
        return view(config('app.interface').'books.danh_sach_co_quan', compact('books'));
    }

    public function create_co_quan() {
        return view(config('app.interface').'books.create_co_quan');   
    }

    public function edit_co_quan($bookId) {
        // get book
        $book = Book::find($bookId);
        if (!$book) {
            flash('Cơ quan không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // view
        return view(config('app.interface').'books.edit_co_quan', compact('book'));   
    }

    public function save_co_quan(Request $request) {
        if ($request->id) {
            $book = Book::find($request->id);
            if (!$book) {
                flash('Cơ quan không tồn tại');
                return redirect(route('co_quan.list'));
            }
            
            $book->update([
                'name' => $request->name,
                'type' => $request->type
            ]);

            flash('Sửa cơ quan thành công');
        }
        else {
            Book::insert([
                'name' => $request->name,
                'type' => $request->type
            ]);

            flash('Thêm cơ quan thành công');
        }

        return redirect(route('co_quan.list'));
    }

    public function delete_co_quan(Request $request) {
        // xóa data
        Book::whereIn('id', $request->ids)->delete();
        BookDetail::whereIn('book_id', $request->ids)->delete();

        flash('Xóa cơ quan thành công');

        return response()->json(['error' => 0]);
    }

    public function get_danh_sach_don_vi($coquanId) {
        // get book
        $book = Book::find($coquanId);
        if (!$book) {
            flash('Cơ quan không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // get bookDetails
        $bookDetails = BookDetail::getList($coquanId)->get();

        // get danh sách users trong mỗi bookDetail
        $users = User::getList()->get()->keyBy('id');
        foreach($bookDetails as $bookDetail) {
            $arrUsers = [];
            foreach($bookDetail->userIds as $userId) {
                if (isset($users[$userId])) {
                    $arrUsers[] = $users[$userId];
                }
            }

            $bookDetail->users = $arrUsers;
        }

        // view
        return view(config('app.interface').'books.danh_sach_don_vi', compact('book', 'bookDetails', 'users'));
    }
    public function quan_ly_don_vi()
    {
        // get data
        $donvis = Donvi::select('donvis.*');
        $keySearch = trim(Input::get('keySearch' . ''));
        if ($keySearch != '') {
            $donvis = $donvis->where(function ($query) use ($keySearch) {
                $query->orwhere('donvis.name', 'like', '%' . $keySearch . '%')
                    ->orwhere('donvis.viettat', 'like', '%' . $keySearch . '%')
                    ->orwhere('donvis.madonvi', 'like', '%' . $keySearch . '%')
                    ->orwhere('donvis.diachi', 'like', '%' . $keySearch . '%');
            });
        }
        $donvis = $donvis->orderBy('donvis.id', 'DESC')
            ->paginate(30)
            ->appends(Input::except('page'));
        return view(config('app.interface').'books.quan_ly_don_vi', compact('donvis', 'keySearch'));
    }

    public function xemdanhsach_cb( $book_id , $donvi_id){

             $currentBook = BookDetail::where('book_id','=', $book_id)->where('donvi_id' , '=' , $donvi_id)->first();
             $userIds = [];
             if (!empty($currentBook)) {
                $userIds = explode(';', $currentBook->user_id);
             }
            $userIds = array_values(array_filter($userIds ));
             $newUsers = [];
            
            $newUsers = User::select('id', 'fullname','email', 'chucdanh')
                            ->whereIn('id', $userIds)
                             ->orderByRaw("FIELD(id, ".implode(",",$userIds).')')
                              ->get();
             $book = Book::find('0000000000'. $book_id);
             $donvi = Donvi::find($donvi_id);

        return view(config('app.interface').'books.danh_sach_nguoi_dung_loai_vb', compact('newUsers','donvi', 'book', 'userIds', 'allUser', 'donvi_id'));
    }

    public function them_don_vi()
    {
        $donvis = Donvi::getList()->get();
        return view(config('app.interface').'books.them_don_vi', compact('donvis'));
    }

    public function luu_don_vi(Request $request)
    {
        $data = Input::all();
        unset($data['_token']);
        $data['ordering'] = 1;

        if (Donvi::create($data)) {
            flash(' Thêm đơn vị thành công');
        } else {
            flash(' Thêm đơn vị  thất bại');
        }
        return redirect(route('quan_ly_don_vi'));
    }

    public function them_can_bo_vao_book ( Request $request ) {
  
        $currentBook = BookDetail::where('book_id','=', $request->book)->where('donvi_id' , '=' , $request->donvi_id)->first();

        if ($currentBook) {
            $currentBook->update([
                'user_id' => $currentBook->user_id .  $request->user . ';'
            ]);
        } else {
           
            BookDetail::insert([
                'book_id' => $request->book,
                'donvi_id' => $request->donvi_id,
                'donvi_email' => ';',
                'user_id' => ';'.$request->user.';'
            ]);
        }
        
        $currentUser = User::find($request->user);
        flash(' Thêm cán bộ thành công');
       return $currentUser;
    }

    public function cap_nhat_vi_tri_can_bo (Request $request) {
        $currentBook = BookDetail::where('book_id','=', $request->book)->where('donvi_id' , '=' , $request->donvi_id)->first();
        $currentBook->update([
            'user_id' => ";". $request->odered . ';'
        ]);
    }

    public function xoa_don_vi(Request $request)
    {
        Donvi::whereIn('id', $request->ids)->delete();

        flash('Xóa đơn vị thành công');

        return response()->json(['error' => 0]);
    }

    public function xoa_can_bo(Request $request)
    {
        $currentBook = BookDetail::where('book_id','=', $request->book)->where('donvi_id' , '=' , $request->donvi_id)->first();
        $currentBook->update([
            'user_id' => ";". $request->user_ids . ';'
        ]);

        flash('Xóa cán bộ thành công');

        return response()->json(['error' => 0]);
    }
    public function sua_don_vi($donviId)
    {
        $donvi = Donvi::find($donviId);
        $parent_donvi = "";

        //kiểm tra xem đó có phải thuộc đơn vị nào không| 0:không, 1:có| nếu có thì lấy tên đơn vị parent ra
        if ($donvi->isDonvi != 0) {
            $parent_donvi = Donvi::findOrFail($donvi->parent_id)->name;
        }
        $donvis = Donvi::getList()->get();

        // Lọc ra các đơn vị không có parent_id trùng với id của đơn vị hiện tại
        foreach ($donvis as $key => $value) {
            if ($value->parent_id == $donvi->id) {
                unset($donvis[$key]);
            }
        }
        return view(config('app.interface').'books.sua_don_vi', compact('donvi', 'donvis', 'parent_donvi'));
    }

    public function cap_nhat_don_vi(Request $request)
    {
        $donvi = Donvi::find($request->donvi_id);
        $data = $request->all();
        if ($donvi->update($data)) {
            flash('Cập nhật đơn vị thành công');
        } else {
            flash('Cập Nhật đơn vị  thất bại');
        }
        return redirect(route('quan_ly_don_vi'));
    }
    public function delete_don_vi(Request $request)
    {
        // xóa data
        BookDetail::whereIn('id', $request->ids)->delete();

        flash('Xóa đơn vị thành công');

        return response()->json(['error' => 0]);
    }

    public function create_don_vi($coquanId) {
        $book = Book::find($coquanId);
        if (!$book) {
            flash('Cơ quan không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // get data for selector
        $donvis = Donvi::getList()->get();
        $users = User::getList()->withDonVi()->get();

        // view
        return view(config('app.interface').'books.create', compact('book', 'donvis', 'users'));   
    }

    public function edit_don_vi($bookDetailId) {
        // get bookdetail
        $bookDetail = BookDetail::find($bookDetailId);
        if (!$bookDetail) {
            flash('Đơn vị không tồn tại');
            return redirect(route('co_quan.list'));
        }

        // get data for selector
        $donvis = Donvi::getList()->get();
        $users = User::getList()->withDonVi()->get();

        // view
        return view(config('app.interface').'books.edit', compact('donvis', 'users', 'bookDetail'));   
    }

    public function save_don_vi(Request $request) {
        if ($request->id) {
            $bookDetail = BookDetail::find($request->id);
            if (!$bookDetail) {
                flash('Đơn vị không tồn tại');
                return redirect(route('co_quan.list'));
            }
            
            $bookDetail->update([
                'donvi_id' => $request->donvi_id,
                'donvi_email' => ';'.str_replace(',', ';', $request->donvi_email).';',
                'user_id' => ';'.implode(';', $request->user_id).';'
            ]);

            flash('Sửa đơn vị thành công');
        }
        else {
            BookDetail::insert([
                'book_id' => $request->book_id,
                'donvi_id' => $request->donvi_id,
                'donvi_email' => ';'.str_replace(',', ';', $request->donvi_email).';',
                'user_id' => ';'.implode(';', $request->user_id).';'
            ]);

            flash('Thêm đơn vị thành công');
        }

        return redirect(route('co_quan.list_don_vi', [$request->book_id]));
    }

    public function getListUser(Request $request){
        $users = User::where([
            ['email', 'like', '%'.$request->term.'%'],
            ['fullname', 'like', '%'.$request->term.'%'],
        ])->limit(20)->get();
        $result = [];
        foreach ($users as $value) {

           $item['id'] = $value['id'];
           $item['text'] = $value['fullname'].' - '.$value['email'];
           array_push($result, $item );
        }
        $data['results'] = $result;
        echo json_encode($data);
    }
   
}
