<?php

namespace App\Http\Controllers;

use App\Mail\HTMLMail;
use Illuminate\Http\Request;
use App\Models\Teachers;
use App\Http\Requests\TeacherRequest;
use App\Models\HistorySendMail;
use App\Http\Requests\UserRequest;
use App\Models\ClassLevel;
use App\Models\District;
use App\Models\FeedBack;
use App\Models\RankSalary;
use App\Models\Schools;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teachers = User::select('users.*', 'class_levels.class as class_id', 'subjects.name as subject', 'time_slots.name as time_tutor_id', 'schools.name as school_id')
                ->leftJoin('class_levels', 'users.class_id', '=', 'class_levels.id')
                ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
                // ->leftJoin('rank_salaries', 'users.salary_id', '=', 'rank_salaries.id')
                ->leftJoin('time_slots', 'users.time_tutor_id', '=', 'time_slots.id')
                ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
                ->where('users.role', 3)
                ->where('status', '1')
                ->get();
            $teachers->transform(function ($teacher) {
                if ($teacher->avatar) {
                    $teacher->avatar = 'http://127.0.0.1:8000/storage/' . $teacher->avatar;
                }
                if ($teacher->Certificate) {
                    $teacher->Certificate = json_decode($teacher->Certificate);
                }
                return $teacher;
            });
            return response()->json($teachers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function getTeacherByClass($class)
    {
        $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class_id', 'subjects.name as subject',  'time_slots.name as time_tutor_id', 'schools.name as school_id')
            ->leftJoin('district', 'users.districtID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class_id', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            // ->leftJoin('rank_salaries', 'users.salary_id', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor_id', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 3)
            ->where('users.class_id', $class)
            ->get();

        $teachers->transform(function ($teacher) {
            if ($teacher->avatar) {
                $teacher->avatar = 'http://127.0.0.1:8000/storage/' . $teacher->avatar;
            }
            if ($teacher->Certificate) {
                $teacher->Certificate = json_decode($teacher->Certificate);
            }
            return $teacher;
        });
        return response()->json($teachers, 200);
    }



    /**
     * Show the form for editing the specified resource.
     */

    public function update(TeacherRequest $request, string $id)
    {
        try {
            $teacher = Teachers::findOrFail($id);

            $validatedData = $request->all();

            $update = $teacher->update($validatedData);

            if ($update) {
                return response()->json($teacher, 200);
            } else {
                return response()->json(['error' => 'Update không thành công'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            $teacher = Teachers::findOrFail($id);
            dd($teacher);
            $teacher->delete();
            return response()->json("Delete success", 204);
        } catch (\Exception $e) {
            return response()->json(['error' => "Xóa không thành công "], 400);
        }
    }

    public function getAllTeacher(Request $request)
    {
        $title = "Danh sách giáo viên";
        $view = 1;
        $subject = Subject::get();
        $teachers = User::where('role', 3)->whereIn('status', [0, 1])->get();
        $class = ClassLevel::get();
        if ($request->post()) {
        // dd($request->post());

            $results = User::with('subject:id,name', 'school:id,name', 'class_levels:id,class')
                ->where('role', 3)
                ->where('status', '1')
                ->when($request->filled('District_ID'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('District_ID', 'like', '%' . $request->input('District_ID') . '%');
                    });
                })
                ->when($request->filled('subject'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('subject', 'like', '%' . $request->input('subject') . '%');
                    });
                })
                ->when($request->filled('class'), function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('class_id', 'like', '%' . $request->input('class') . '%');
                    });
                })
                ->get();
            $teachers = $results;

        }
        // dd($subject);
        return view('backend.teacher.index', compact('teachers', 'title', 'view', 'subject', 'class'));
    }

    public function addNewTeacher(TeacherRequest $request)
    {
        $title = "Thêm mới giáo viên";
        // $district = District::all();
        $school = Schools::all();
        $subject = Subject::all();
        $class = ClassLevel::all();
        $salary = RankSalary::all();
        $timeTutor = TimeSlot::all();

        if ($request->isMethod('post')) {
            // $params = $request->post();
            $params = $request->except('_token');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $params['avatar'] = uploadFile('hinh', $request->file('avatar'));
            }else {
                $params['avatar']= 'hinh/anhdefault.png';
            }
            $teacher = new User();
            $teacher->role = $request->role;
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->password =  Hash::make($request->password);
            $teacher->avatar = $params['avatar'];
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->school_id = $request->school_id;
            $teacher->education_level = $request->education_level;
            $teacher->class_id = $request->class;
            $teacher->subject = $request->subject;
            $teacher->salary_id = $request->salary;
            $teacher->description = $request->description;
            $teacher->time_tutor_id = $request->time_tutor;
            $teacher->status = $request->status;
            // $teacher->DistrictID = $request->DistrictID;
            $teacher->current_role = $request->current_role;
            $teacher->exp = $request->exp;
            if ($request->hasFile('Certificate')) {
                $certificates = [];

                foreach ($request->file('Certificate') as $file) {
                    if ($file->isValid()) {
                        $certificates[] = uploadFile('hinh', $file);
                    }
                }
                $teacher->Certificate = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON
            } else {
                $teacher->Certificate = null;
            }
            $teacher->date_of_birth = $request->date_of_birth;
            $teacher->gender = $request->gender;
            //            $teacher->fill($params);
            $teacher->save();
            if ($teacher->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_teacher');
            } else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }

        return view('backend.teacher.add', compact('title', 'school', 'subject', 'class', 'salary', 'timeTutor'));
    }
    public function updateTeacher(UserRequest $request, $id)
    {
        $title = "Sửa thông tin giáo viên";
        // $district = District::all();
        $school = Schools::all();
        $subject = Subject::all();
        $class = ClassLevel::all();
        $salary = RankSalary::all();
        $timeTutor = TimeSlot::all();
        $teacher = User::findOrFail($id);

        // dd(json_decode($teacher['Certificate']));
        // dd($teacher);
        if ($request->isMethod('post')) {
            $params = $request->except('_token');
            if ($request->hasFile('Certificate')) {
                if ($params['Certificatelast'] != null) {
                    $imagelast = json_decode($params['Certificatelast']);
                    foreach ($imagelast as $i) {
                        Storage::delete('/public/' . $i);
                    }
                }

                $certificates = [];

                foreach ($request->file('Certificate') as $file) {
                    if ($file->isValid()) {
                        $certificates[] = 'http://127.0.0.1:8000/storage/' . uploadFile('hinh', $file);
                    }
                }
                $params['Certificate'] = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON

            } else {
                $params['Certificate'] = $params['Certificatelast'];
            }

            unset($params['Certificatelast']);
            $data = $params;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $teacher->avatar);
                if ($deleteImage) {
                    $data['avatar'] = uploadFile('hinh', $request->file('avatar'));
                }
            }

            $data['password'] =  Hash::make($data['password']);

            // $update = User::where('id', $id)->update($request->except('_token'));
            $update = User::where('id', $id)->update($data);
            if ($update) {
                // dd($data['Certificate']);
                Session::flash('success', 'Sửa thông tin giáo viên thành công');
                return redirect()->route('search_teacher');
            } else {
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.teacher.edit', compact('teacher', 'title', 'school', 'subject', 'class', 'salary', 'timeTutor'));
    }

    public function getTeacherByFilter(Request $request)
    {
        $results = User::with('subject:id,name', 'school:id,name', 'class_levels:id,class', 'timeSlot:id,name')
            ->where('role', 3)
            ->where('status', '1')
            ->when($request->filled('District_ID'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('District_ID', 'like', '%' . $request->input('District_ID') . '%');
                });
            })
            ->when($request->filled('subject'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('subject', 'like', '%' . $request->input('subject') . '%');
                });
            })
            ->when($request->filled('class'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('class_id', 'like', '%' . $request->input('class') . '%');
                });
            })
            ->get();
    
        $processedRecords = $results->map(function ($record) {
            $newArraySubject = [];
            if ($record->subject != null) {
                $makeSubject = explode(',', $record->subject);
                foreach ($makeSubject as $item) {
                    $subjectNew = Subject::find($item);
                    if ($subjectNew) {
                        array_push($newArraySubject, [
                            'id' => $subjectNew->id,
                            'name' => $subjectNew->name,
                        ]);
                    }
                }
            }
    
            $newArrayClass = [];
            if ($record->class_id != null) {
                $makeClass = explode(',', $record->class_id);
                foreach ($makeClass as $item) {
                    $classNew = ClassLevel::find($item);
                    if ($classNew) {
                        array_push($newArrayClass, [
                            'id' => $classNew->id,
                            'class' => $classNew->class,
                        ]);
                    }
                }
            }
    
            // Thêm tính điểm trung bình cho giáo viên
            $averagePoint = $this->averagePointTeacher($record->id);
    
            if ($record->Certificate) {
                $record->Certificate = json_decode($record->Certificate);
            }
    
            return [
                'id' => $record->id,
                'name' => $record->name,
                'avatar' => 'http://127.0.0.1:8000/storage/' . $record->avatar,
                'class_id' => $newArrayClass,
                'subject' => $newArraySubject,
                'district' => $record->District_ID,
                'average_point' => $averagePoint,
            ];
        });
    
        return response()->json($processedRecords, 200);
    }
    
    public function averagePointTeacher(string $id)
    {
        $data = FeedBack::select('feedback.*', 'users.name as id_sender')
            ->leftJoin('users', 'feedback.id_sender', '=', 'users.id')
            ->where('feedback.id_teacher', $id)
            ->get();
        $dataArray = json_decode($data, true);
        $totalPoints = 0;
        $count = count($dataArray);
    
        foreach ($dataArray as $item) {
            $totalPoints += (int) $item['point'];
        }
    
        $averagePoint = ($count > 0) ? $totalPoints / $count : 0;
    
        return $averagePoint;
    }
    

    public function delete(Request $request,$id, $view)
    {

        if ($id) {
            $user = User::find($id);

            if ($user) {
                if ($view == 1) {
                    $user->delete();
                    Session::flash('success', 'success');
                    return redirect()->route('search_teacher');
                } else {
                    if(!$request->reason){
                        Session::flash('error', 'Vui lòng nhập lý do từ chối');
                        return redirect()->route('deatailWaitingTeacher',['id'=>$id]);
                    }
                    $user->status =5;
                    $user->save();
                    $htmlContent="<h3>Tài khoản của bạn bị từ chối vì lý do:</h3> <br>
                        <span>$request->reason</span>";
                    Mail::to($user->email)->send(new HTMLMail($htmlContent));
                    $new_history_sendmail = new HistorySendMail;
                    $new_history_sendmail->id_user = $id;
                    $new_history_sendmail->email = $request->email;
                    $new_history_sendmail->type = '11';
                    $new_history_sendmail->content = "Tài khoản của bạn bị từ chối vì lý do $request->reason";
                    $new_history_sendmail->save();
                    Session::flash('success', 'success');
                    return redirect()->route('waiting');
                }
            } else {
                Session::flash('error', 'error');
            }
        }
    }

    public function getSubjectAndClass($id)
    {
        $records = User::where('id', $id)->first();

        // Kiểm tra xem $records có tồn tại không
        if ($records) {
            $newArraySubject = [];
            if ($records->subject != null) {
                $makeSubject = explode(',', $records->subject);
                foreach ($makeSubject as $item) {
                    $subjectNew = Subject::find($item);
                    // Kiểm tra xem $subjectNew có tồn tại không
                    if ($subjectNew) {
                        array_push($newArraySubject, ['id' => $subjectNew->id, 'name' => $subjectNew->name]);
                    }
                }
            }

            $newArrayClass = [];
            if ($records->class_id != null) {
                $makeClass = explode(',', $records->class_id);
                foreach ($makeClass as $item) {
                    $classNew = ClassLevel::find($item);
                    // Kiểm tra xem $classNew có tồn tại không
                    if ($classNew) {
                        array_push($newArrayClass, ['id' => $classNew->id, 'class' => $classNew->class]);
                    }
                }
            }

            return response()->json([
                'class_id' => $newArrayClass,
                'subject' => $newArraySubject,
            ], 200);
        } else {
            // Trả về một phản hồi nếu không tìm thấy người dùng với ID tương ứng
            return response()->json(['error' => 'User not found'], 404);
        }
    } 

    public function getTeacherByStar(){
        $query = DB::table('feedback')
            ->select(
                'users.id',
                'users.name',
                'users.avatar',
                'users.District_ID',
                'subjects.id as subject_id', // Add subject ID
                'subjects.name as subject_name', // Alias for subjects.name
                'class_levels.id as class_id', // Add class ID
                'class_levels.class as class_name', // Alias for class_levels.name
                'users.class_id',
                DB::raw('AVG(feedback.point) AS avg_point')
            )
            ->join('users', 'feedback.id_teacher', '=', 'users.id')
            ->join('subjects', 'users.subject', '=', 'subjects.id') // Join with subjects table
            ->join('class_levels', 'users.class_id', '=', 'class_levels.id') // Join with class_levels table
            ->groupBy(
                'users.id',
                'users.name',
                'users.avatar',
                'users.District_ID',
                'subjects.id', // Group by subject ID
                'subjects.name', // Group by subject name
                'class_levels.id', // Group by class ID
                'class_levels.class', // Group by class level name
                'users.class_id'
            )
            ->orderBy('avg_point', 'desc')
            ->limit(4);
        
        $results = $query->get();
    
        $processedRecords = $results->map(function ($record) {
            $newArrayClass = [];
            if ($record->class_id != null) {
                $makeClass = explode(',', $record->class_id);
                foreach ($makeClass as $item) {
                    $classNew = ClassLevel::find($item);
                    if ($classNew) {
                        array_push($newArrayClass, [
                            'id' => $classNew->id,
                            'class' => $classNew->class,
                        ]);
                    }
                }
            }
    
            return [
                'id' => $record->id,
                'name' => $record->name,
                'avatar' => 'http://127.0.0.1:8000/storage/' . $record->avatar,
                'class_id' => $newArrayClass,
                'subject' => [
                    'id' => $record->subject_id,
                    'name' => $record->subject_name,
                ],
                'district' => $record->District_ID,
                'avg_point' => $record->avg_point,
            ];
        });
    
        return response()->json($processedRecords, 200);
    }
    
    
    
    
}
