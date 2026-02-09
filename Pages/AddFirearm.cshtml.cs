using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;
using System.ComponentModel.DataAnnotations;

namespace Gunventory.Pages;

[Authorize]
public class AddFirearmModel : PageModel
{
    private readonly GunventoryContext _context;
    private readonly IWebHostEnvironment _environment;

    public AddFirearmModel(GunventoryContext context, IWebHostEnvironment environment)
    {
        _context = context;
        _environment = environment;
    }

    [BindProperty]
    public InputModel Input { get; set; } = new();

    public SelectList GunTypes { get; set; } = default!;
    public SelectList Calibers { get; set; } = default!;

    public class InputModel
    {
        [Required]
        [MaxLength(30)]
        public string Manufacturer { get; set; } = string.Empty;

        [Required]
        [MaxLength(50)]
        public string Model { get; set; } = string.Empty;

        [Required]
        [Display(Name = "Gun Type")]
        public int GunTypeId { get; set; }

        [Required]
        [Display(Name = "Caliber")]
        public int CaliberId { get; set; }

        [Required]
        [MaxLength(20)]
        public string Serial { get; set; } = string.Empty;

        [Required]
        [DataType(DataType.Date)]
        [Display(Name = "Purchase Date")]
        public DateTime PurchaseDate { get; set; } = DateTime.Now;

        public decimal Price { get; set; }

        [MaxLength(50)]
        public string? Notes { get; set; }

        public IFormFile? Image { get; set; }
        public IFormFile? Document { get; set; }
    }

    public void OnGet()
    {
        GunTypes = new SelectList(_context.GunTypes.Where(t => t.Status == "A"), "Id", "Name");
        Calibers = new SelectList(_context.Calibers.Where(c => c.Status == "A"), "Id", "Name");
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (!ModelState.IsValid)
        {
            GunTypes = new SelectList(_context.GunTypes.Where(t => t.Status == "A"), "Id", "Name");
            Calibers = new SelectList(_context.Calibers.Where(c => c.Status == "A"), "Id", "Name");
            return Page();
        }

        var firearm = new Firearm
        {
            Manufacturer = Input.Manufacturer,
            Model = Input.Model,
            GunTypeId = Input.GunTypeId,
            CaliberId = Input.CaliberId,
            Serial = Input.Serial,
            PurchaseDate = Input.PurchaseDate,
            Price = Input.Price,
            Notes = Input.Notes,
            Status = "A",
            STimestamp = DateTime.Now
        };

        if (Input.Image != null)
        {
            firearm.ImgURL = await SaveFile(Input.Image, "img/uploads");
        }

        if (Input.Document != null)
        {
            firearm.DocURL = await SaveFile(Input.Document, "img/uploads");
        }

        _context.Firearms.Add(firearm);
        await _context.SaveChangesAsync();

        return RedirectToPage("/Index");
    }

    private async Task<string> SaveFile(IFormFile file, string subDir)
    {
        var fileName = Path.GetFileNameWithoutExtension(file.FileName) + "_" + DateTimeOffset.UtcNow.ToUnixTimeSeconds() + Path.GetExtension(file.FileName);
        var filePath = Path.Combine(_environment.WebRootPath, subDir, fileName);

        Directory.CreateDirectory(Path.GetDirectoryName(filePath)!);

        using (var stream = System.IO.File.Create(filePath))
        {
            await file.CopyToAsync(stream);
        }

        return $"./{subDir}/{fileName}";
    }
}
